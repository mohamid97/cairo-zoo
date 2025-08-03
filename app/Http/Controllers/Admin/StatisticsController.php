<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StatisticsExport;
use App\Http\Controllers\Controller;
use App\Models\Admin\CahierOrderInfo;
use App\Models\Admin\CashierOrder;
use App\Models\Admin\DiffPrice;
use App\Models\Admin\Expense;
use App\Models\Admin\ExpenseAmount;
use App\Models\Admin\OrderInfo;
use App\Models\Admin\Product;
use App\Models\Front\Order;
use App\Models\Front\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StatisticsController extends Controller
{
    //
    public function diff(Request $request){

        $query = DiffPrice::with('product');

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $diffs = $query->paginate(20);

        return view('admin.cahier_orders.diff', compact('diffs'));


    } //


    public function store_data(Request $request)
    {
        $query = Product::with('stocks');
        if ($request->product_id) {
            $query->where('id', $request->product_id);
        }

        // Paginate the query directly
        $products = $query->paginate(10);

        return view('admin.statistics.store_data', ['products'=>$products  , 'all_products'=>Product::all() , 'selectedProduct'=>$request->product_id ?? null]);
    }

    public function orders(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        // Set default date range (last 30 days) if dates not provided
        $start = $request->start_date ?? now()->subDays(30)->format('Y-m-d');
        $end = $request->end_date ?? now()->format('Y-m-d');

        // Online orders query with retrieval status
        $onlineOrders = Order::query()
            ->when($request->start_date || $request->end_date, function($query) use ($start, $end) {
                $query->whereBetween('created_at', [$start, $end]);
            }, function($query) {
                $query->where('created_at', '>=', now()->subDays(30));
            })
            ->selectRaw('
            GROUP_CONCAT(id) as order_ids,
            COUNT(*) as total_orders,
            SUM(total_price_after_discount) as total_revenue,
            SUM(shipment_price) as total_shipment,
            SUM(CASE WHEN status = "finshed" THEN shipment_price ELSE 0 END) as total_shipment_complete,
            SUM(CASE WHEN status = "finshed" THEN total_price_after_discount ELSE 0 END) as completed_revenue,
            SUM(CASE WHEN status = "canceled" THEN total_price_after_discount ELSE 0 END) as canceled_revenue,
            SUM(CASE WHEN status = "retrieval" THEN total_price_after_discount ELSE 0 END) as retrieval_revenue,
            SUM(CASE WHEN status = "pending" THEN total_price_after_discount ELSE 0 END) as pending_revenue,
            SUM(CASE WHEN status = "procced" THEN total_price_after_discount ELSE 0 END) as procced_revenue,
            SUM(CASE WHEN status = "on-way" THEN total_price_after_discount ELSE 0 END) as on_way_revenue,
            SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending_orders,
            SUM(CASE WHEN status = "procced" THEN 1 ELSE 0 END) as processing_orders,
            SUM(CASE WHEN status = "on-way" THEN 1 ELSE 0 END) as on_way_orders,
            SUM(CASE WHEN status = "retrieval" THEN 1 ELSE 0 END) as retrieval_orders,
            SUM(CASE WHEN status = "canceled" THEN 1 ELSE 0 END) as canceled_orders,
            SUM(CASE WHEN status = "finshed" THEN 1 ELSE 0 END) as finshed_orders
        ')->first();

        $diff = 0;

        if($onlineOrders->order_ids){

            $orderIds = explode(',', $onlineOrders->order_ids);
            $orders = Order::with(['items'])->whereIn('id', $orderIds)->where('status' , 'finshed')->get();


            if($orders){
                foreach ($orders as $order){
                    foreach ($order->items as $item){
                        $product = $item->product;
                        $orderInfos = OrderInfo::where('order_id' , $order->id)->where('product_id' , $product->id)->get();
                        $item_sales_price = $item->sales_price / $item->quantity;
                        $price = $item->price / $item->quantity;
                        foreach ($orderInfos as $info){
                            if($info->sales_price  < $item_sales_price){
                                if($info->sales_price < $price){
                                    $diff += $info->qty * ($price - $info->sales_price);
                                }

                            }
                        }

                    }

                }
            }




        }
        $onlineOrders->diff = $diff;

        // Cashier orders query
        $cashierOrders = CashierOrder::query()
            ->when($request->start_date || $request->end_date, function($query) use ($start, $end) {
                $query->whereBetween('created_at', [$start, $end]);
            }, function($query) {
                $query->where('created_at', '>=', now()->subDays(30));
            })
            ->selectRaw('
             GROUP_CONCAT(id) as order_ids,
            COUNT(*) as total_orders,
            SUM(total_amount_after_discount) as total_revenue,
            SUM(CASE WHEN status = "finshed" THEN total_amount_after_discount ELSE 0 END) as completed_revenue,
            SUM(CASE WHEN status = "canceled" THEN total_amount_after_discount ELSE 0 END) as canceled_revenue,
            SUM(CASE WHEN status = "retrieval" THEN total_amount_after_discount ELSE 0 END) as retrieval_revenue,
            SUM(CASE WHEN status = "retrieval" THEN 1 ELSE 0 END) as retrieval_orders,
            SUM(CASE WHEN status = "canceled" THEN 1 ELSE 0 END) as canceled_orders,
            SUM(CASE WHEN status = "finshed" THEN 1 ELSE 0 END) as completed_orders

        ')
            ->first();

        $cahierdiff = 0;
        if($cashierOrders->order_ids){
            $cashierOrderIds = explode(',', $cashierOrders->order_ids);
            $cashierOrdersFinished = CashierOrder::with(['items'])->whereIn('id', $cashierOrderIds)->where('status' , 'finshed')->get();

            if($cashierOrdersFinished){
                foreach ($cashierOrdersFinished as $order){
                    foreach ($order->items as $item){
                        $product = $item->product;
                        $orderInfos = CahierOrderInfo::where('order_id' , $order->id)->where('product_id' , $product->id)->get();
                        $item_sales_price = $item->sales_price / $item->quantity;
                        $price = $item->price / $item->quantity;
                        foreach ($orderInfos as $info){
                            if($info->sales_price  < $item_sales_price){
                                if($info->sales_price < $price){
                                    $cahierdiff += $info->qty * ($price - $info->sales_price);
                                }
                            }
                        }

                    } // end foreach of order items

                } // loop for finished orders

            } // check of has cashier order

        }
        $cashierOrders->diff = $cahierdiff;

        $combinedStats = [
            'total_orders' => ($onlineOrders->total_orders ?? 0) + ($cashierOrders->total_orders ?? 0),
            'total_revenue' => ($onlineOrders->total_revenue ?? 0) + ($cashierOrders->total_revenue ?? 0),
            'total_complete'=>($onlineOrders->completed_revenue ?? 0) + ($cashierOrders->completed_revenue ?? 0),
            'retrieval_revenue' => ($onlineOrders->retrieval_revenue ?? 0) + ($cashierOrders->retrieval_revenue ?? 0),

        ];

        return view('admin.statistics.orders', [
            'online_orders' => $onlineOrders,
            'cashier_orders' => $cashierOrders,
            'combined_stats' => $combinedStats,
            'start_date' => $start,
            'end_date' => $end
        ]);
    }




    private function get_monthly_data($date){
        $date = $date ? Carbon::parse($date) : now();
        $year = $date->year;
        $month = $date->month;


        // Fetch orders with optimized queries
        $onlineOrders = Order::with('order_info')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 'finshed')
            ->get();

        $cashierOrders = CashierOrder::with('order_info')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 'finshed')
            ->get();

                    // Calculate metrics
        $onlineRevenue = $onlineOrders->sum('total_price_after_discount');

        $onlineShipment = $onlineOrders->sum('shipment_price');
        $onlineCost = $onlineOrders->sum(fn($order) =>
            $order->order_info->sum(fn($info) => $info->cost_price * $info->qty)
        );
        $onlineProfit = $onlineRevenue - $onlineCost;

        $cashierRevenue = $cashierOrders->sum('total_amount_after_discount');
        $cashierCost = $cashierOrders->sum(fn($order) =>
            $order->order_info->sum(fn($info) => $info->cost_price * $info->qty)
        );
        $cashierProfit = $cashierRevenue - $cashierCost;



    // Expenses
    $totalVariableExpenses = ExpenseAmount::whereHas('expense', fn($q) => $q->where('type', 'variable'))
        ->whereYear('date', $year)
        ->whereMonth('date', $month)
        ->sum('amount');

    $totalFixedExpenses = Expense::where('type', 'fixed')
        ->with(['expenseAmounts' => fn($q) => $q->whereYear('date', $year)->whereMonth('date', $month)])
        ->with('latestAmount')
        ->get()
        ->sum(fn($expense) => optional($expense->expenseAmounts->first() ?? $expense->latestAmount)->amount ?? 0);


        return [
            'date' => $date,
            'online' => [
                'revenue' => $onlineRevenue,
                'shipment' => $onlineShipment,
                'cost' => $onlineCost,
                'profit' => $onlineProfit,
            ],
            'cashier' => [
                'revenue' => $cashierRevenue,
                'cost' => $cashierCost,
                'profit' => $cashierProfit,
            ],
            'total_revenue' => $onlineRevenue + $cashierRevenue,
            'total_variable_expenses' => $totalVariableExpenses,
            'total_fixed_expenses' => $totalFixedExpenses,
            'net_profit' => ($onlineProfit + $cashierProfit + $onlineShipment) -
                        ($totalVariableExpenses + $totalFixedExpenses)
        ] ;



    }

    public function monthly_report(Request $request)
    {
        $request->validate([
            'date' => 'nullable|date',
        ]);

        return view('admin.statistics.monthly_statistics', $this->get_monthly_data($request->date));
    } // end monthly report



    public function export(Request $request)
    {
    $request->validate([
        'date' => 'nullable|date',
        'type'=>'required'
    ]);
        $type = $request->type;

        if ($type === 'pdf') {
            $pdf = Pdf::loadView('admin.statistics.export_pdf', $this->get_monthly_data($request->date));
            return $pdf->download('monthly-report.pdf');
        } elseif ($type === 'excel') {

                $data = $this->get_monthly_data($request->date);
                // Create new Spreadsheet
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $spreadsheet->getProperties()
                ->setCreator(config('app.name'))
                ->setTitle('Monthly Statistics Report - '.$request->date??now()->format('F Y'))
                ->setSubject('Monthly Financial Report');
                $sheet->setCellValue('A1', 'Monthly Statistics Report - '.$request->date??now()->format('F Y'));
                $sheet->mergeCells('A1:B1');
                $sheet->setCellValue('A2', 'Generated on: '.now()->format('Y-m-d H:i'));
                $sheet->mergeCells('A2:B2');

                $sheet->getStyle('A1:B1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                        'color' => ['rgb' => '000000']
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ]
                ]);

                $sheet->getStyle('A2:B2')->applyFromArray([
                    'font' => [
                        'italic' => true,
                        'color' => ['rgb' => '666666']
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ]
                ]);



                $sheet->setCellValue('A4', 'Online Orders');
                $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(14);
                $sheet->fromArray([
                    ['Revenue', $data['online']['revenue']],
                    ['Shipment Revenue',  $data['online']['shipment']],
                    ['Cost', $data['online']['cost']],
                    ['Gross Profit', $data['online']['profit']]
                ], null, 'A5');




                $sheet->setCellValue('A10', 'Cashier Orders');
                $sheet->getStyle('A10')->getFont()->setBold(true)->setSize(14);
                $sheet->fromArray([
                    ['Revenue', $data['cashier']['revenue']],
                    ['Cost', $data['cashier']['cost']],
                    ['Gross Profit', $data['cashier']['profit']]
                ], null, 'A11');




            $sheet->setCellValue('A15', 'Summary');
            $sheet->getStyle('A15')->getFont()->setBold(true)->setSize(14);
            $sheet->fromArray([
                ['Total Profit', $data['online']['profit'] + $data['cashier']['profit']],
                ['Total Shipment', $data['online']['shipment']],
                ['Variable Expenses', $data['total_variable_expenses']],
                ['Fixed Expenses', $data['total_fixed_expenses']],
                ['Net Profit', $data['net_profit']]
            ], null, 'A16');



            $sheet->getStyle('B5:B20')
            ->getNumberFormat()
            ->setFormatCode('#,##0.00');


            $profitRows = [8, 13, 19]; // Adjust based on your actual row numbers
            foreach ($profitRows as $row) {
                $sheet->getStyle('A'.$row.':B'.$row)
                    ->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'color' => ['rgb' => '008000']
                        ]
                    ]);
            }

            $sheet->getStyle('A16:B16')
            ->applyFromArray([
                'font' => [
                    'bold' => true
                ]
            ]);

            $sheet->getColumnDimension('A')->setWidth(25);
            $sheet->getColumnDimension('B')->setWidth(15);

            $sheet->getStyle('A4:B'.($sheet->getHighestRow()))
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $writer = new Xlsx($spreadsheet);
            $filename = 'monthly_report_'.$request->date??now()->format('Y_m').'.xlsx';

            $response = new StreamedResponse(
                function () use ($writer) {
                    $writer->save('php://output');
                }
            );

            $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename.'"');
            $response->headers->set('Cache-Control', 'max-age=0');

            return $response;
        }

        return back()->with('error', 'Invalid export type.');
    }






    } // end expoert monthly report
