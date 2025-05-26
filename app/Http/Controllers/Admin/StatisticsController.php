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
        ')
            ->first();

        $orderIds = explode(',', $onlineOrders->order_ids);
        $orders = Order::with(['items'])->whereIn('id', $orderIds)->where('status' , 'finshed')->get();

        $diff = 0;
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


        if($cashierOrders->order_ids){
            $cashierOrderIds = explode(',', $cashierOrders->order_ids);
            $cashierOrders = CashierOrder::with(['items'])->whereIn('id', $cashierOrderIds)->where('status' , 'finshed')->get();
            $cahierdiff = 0;
            foreach ($cashierOrders as $order){
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

                }

            }

            $cashierOrders->diff =$cahierdiff;
        }


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


    // monthly statistics
    public function monthly_report(Request $request)
    {
        $request->validate([
            'date' => 'nullable|date',
        ]);

        // if no date is provided, use the current month
        if (!$request->date) {
            $date = now();
        } else {
            $date = $request->date;
        }





        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));

        //dd($year , $month);

        $onlineOrders = Order::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->selectRaw('
                SUM(CASE WHEN status = "finshed" THEN shipment_price ELSE 0 END) as total_shipment_complete,
                SUM(CASE WHEN status = "finshed" THEN total_price_after_discount ELSE 0 END) as completed_revenue
            ')
            ->first();


        $cashierOrders = CashierOrder::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->selectRaw('
                SUM(CASE WHEN status = "finshed" THEN total_amount_after_discount ELSE 0 END) as completed_revenue
            ')
            ->first();


            $combinedStats = [
                'total_revenue' => ($onlineOrders->completed_revenue ?? 0) + ($cashierOrders->completed_revenue ?? 0),
            ];



            $totalVariableExpenses = ExpenseAmount::whereHas('expense', function ($query) {
                    $query->where('type', 'variable');
                })
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->sum('amount');


            $totalFixedExpenses = Expense::where('type', 'fixed')
                ->with(['expenseAmounts' => function ($query) use ($year, $month) {
                    $query->whereYear('date', $year)
                        ->whereMonth('date', $month);
                }])
                ->with('latestAmount')
                ->get()
                ->sum(function ($expense) {
                    if ($expense->expenseAmounts->isNotEmpty()) {
                        return $expense->expenseAmounts->first()->amount;  // amount for this month
                    }
                    return optional($expense->latestAmount)->amount ?? 0; // fallback latest amount
                });






            return view('admin.statistics.monthly_statistics', [
                'online_orders' => $onlineOrders,
                'cashier_orders' => $cashierOrders,
                'combined_stats' => $combinedStats,
                'total_variable_expenses' => $totalVariableExpenses,
                'total_fixed_expenses' => $totalFixedExpenses,
                'date' => $date,


            ]);




        }



    public function export(Request $request)
    {
        $type = $request->type;
        $date = $request->date ?? now();

        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));

        $onlineOrders = Order::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->selectRaw('
            SUM(CASE WHEN status = "finshed" THEN shipment_price ELSE 0 END) as total_shipment_complete,
            SUM(CASE WHEN status = "finshed" THEN total_price_after_discount ELSE 0 END) as completed_revenue
        ')
            ->first();

        $cashierOrders = CashierOrder::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->selectRaw('
            SUM(CASE WHEN status = "finshed" THEN total_amount_after_discount ELSE 0 END) as completed_revenue
        ')
            ->first();

        $totalVariableExpenses = ExpenseAmount::whereHas('expense', function ($query) {
            $query->where('type', 'variable');
        })
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->sum('amount');

        $totalFixedExpenses = Expense::where('type', 'fixed')
            ->with(['expenseAmounts' => function ($query) use ($year, $month) {
                $query->whereYear('date', $year)
                    ->whereMonth('date', $month);
            }])
            ->with('latestAmount')
            ->get()
            ->sum(function ($expense) {
                if ($expense->expenseAmounts->isNotEmpty()) {
                    return $expense->expenseAmounts->first()->amount;
                }
                return optional($expense->latestAmount)->amount ?? 0;
            });

        $data = [
            'date' => $date,
            'online_orders' => $onlineOrders,
            'cashier_orders' => $cashierOrders,
            'total_variable_expenses' => $totalVariableExpenses,
            'total_fixed_expenses' => $totalFixedExpenses,
            'total_revenue' => ($onlineOrders->completed_revenue ?? 0) + ($cashierOrders->completed_revenue ?? 0),
        ];

        if ($type === 'pdf') {
            $pdf = Pdf::loadView('admin.statistics.export_pdf', compact('data'));
            return $pdf->download('monthly-report.pdf');
        } elseif ($type === 'excel') {
            // Create new Spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set headers
            $sheet->setCellValue('A1', 'Category');
            $sheet->setCellValue('B1', 'Amount');

            // Add data rows
            $rows = [
                ['Date', $data['date']],
                ['Online Orders Revenue', $data['online_orders']->completed_revenue ?? 0],
                ['Cashier Orders Revenue', $data['cashier_orders']->completed_revenue ?? 0],
                ['Total Revenue', $data['total_revenue']],
                ['Variable Expenses', $data['total_variable_expenses']],
                ['Fixed Expenses', $data['total_fixed_expenses']],
                ['Net Profit', $data['total_revenue'] - $data['total_variable_expenses'] - $data['total_fixed_expenses']],
            ];

            $sheet->fromArray($rows, null, 'A2');

            // Style the header
            $sheet->getStyle('A1:B1')->getFont()->setBold(true);

            // Auto-size columns
            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);

            // Create and return the file
            $writer = new Xlsx($spreadsheet);

            $response = new StreamedResponse(
                function () use ($writer) {
                    $writer->save('php://output');
                }
            );

            $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $response->headers->set('Content-Disposition', 'attachment;filename="monthly-report.xlsx"');
            $response->headers->set('Cache-Control', 'max-age=0');

            return $response;
        }

        return back()->with('error', 'Invalid export type.');
    }






    }
