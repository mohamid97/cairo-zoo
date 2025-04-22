<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Cms;
use App\Models\Admin\Lang;
use App\Models\Admin\MediaGroup;
use App\Models\Admin\Message;
use App\Models\Admin\Offers;
use App\Models\Admin\Points;
use App\Models\Admin\Product;
use App\Models\Admin\Service;
use App\Models\Admin\Slider;
use App\Models\Front\Card;
use App\Models\Front\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // index function return home admin page

    public function index()
    {

        $users      = User::where('type' ,'!=' , 'admin')->count();
        $messages   = Message::count();
        $categories = Category::count();
        $products   = Product::count();
        $services   = Service::count();
        $blogs       = Cms::count();
        $langs       = Lang::count();
        $media_group = MediaGroup::count();
        $sliders     = Slider::count();
        $latest_messages = Message::latest()->take(5)->get();
        $cards = Card::count();
        $orders = Order::count();
        $offers = Offers::count();
        // Fetch the latest 10 orders along with related user and order items
        $latest_orders = Order::with('user', 'items')
        ->orderBy('created_at', 'desc')
        ->take(10)
        ->get();
        $latest_cards = Card::with(['user' , 'items.product'])->latest()->take(10)->get();
                // Calculate total price for each card
                foreach ($latest_cards  as $card) {
                    $card->total_price = $card->items->sum(function ($item) {
                        return $item->product->price * $item->quantity;
                    });
                }


        $lowest_stock = Product::where('stock' , '<' , 10)->take(10)->get();

                $possibleStatuses = ['pending', 'finshed', 'canceled', 'procced', 'on-way'];
                // Order Status Counts
                $orderStatusCounts = Order::selectRaw('status, count(*) as count')
                    ->groupBy('status')
                    ->pluck('count', 'status')
                    ->toArray();
                                        // Fill missing statuses with zero
                    foreach ($possibleStatuses as $status) {
                        if (!array_key_exists($status, $orderStatusCounts)) {
                            $orderStatusCounts[$status] = 0;
                        }
                    }
                        // Ensure keys are sorted by the possible statuses
                    $orderStatusCounts = array_replace(array_flip($possibleStatuses), $orderStatusCounts);
                    $productsStockCounts = Product::with('translations')
                    ->select('id', 'stock')
                    ->get()
                    ->mapWithKeys(function ($product) {
                        // Get the translated name for the current locale
                        $translatedName = $product->translate()->name ?? 'Unnamed Product';
                        return [$translatedName => $product->stock];
                    })
                    ->toArray();

                    $categoryProductCounts = Category::with('translations')
                    ->withCount('products') // Count related products
                    ->get()
                    ->mapWithKeys(function ($category) {
                    // Get the translated name for the current locale
                    $translatedName = $category->translate()->name ?? 'Unnamed Category';
                    return [$translatedName => $category->products_count]; // Use the counted value
                    })
                    ->toArray();

                    //check
                    $usersWithOrders = User::has('orders')->where('type' , '!=' , 'admin')->count();
                    $usersWithoutOrders = User::doesntHave('orders')->where('type' , '!=' , 'admin')->count();

                    $currentMonth = Carbon::now()->month;

                    // Get sales data for each month up to the current month
                    $monthlySales = Order::where('status', 'finshed')
                        ->whereYear('created_at', Carbon::now()->year)
                        ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total_sales')
                        ->groupBy('month')
                        ->orderBy('month')
                        ->get()
                        ->pluck('total_sales', 'month')
                        ->toArray();

                    // Fill in any missing months with zero sales
                    $salesData = [];
                    for ($i = 1; $i <= $currentMonth; $i++) {
                        $salesData[] = $monthlySales[$i] ?? 0;
                    }
        $totalPoints = Points::sum('points'); // Sums up all points

        return view('admin.home' , [
            'users'           => $users,
            'messages'        => $messages,
            'categories'      => $categories,
            'products'        => $products,
            'services'        => $services,
            'blogs'           => $blogs,
            'latest_messages' => $latest_messages,
            'langs'           => $langs,
            'media_group'     =>$media_group,
            'sliders'         => $sliders,
            'cards'           => $cards,
            'orders'          => $orders,
            'offers'          => $offers,
            'latest_orders'   =>$latest_orders,
            'latest_cards'    =>$latest_cards,
           'orderStatusCounts' => $orderStatusCounts,
           'productsStockCounts' =>  $productsStockCounts,
           'categoryProductCounts'=>$categoryProductCounts,
           'usersWithOrders'=>$usersWithOrders,
           'usersWithoutOrders'=>$usersWithoutOrders,
           'salesData'=>$salesData,
           'currentMonth'=>$currentMonth,
           'lowest_stock'=> $lowest_stock,
            'totalPoints'=>$totalPoints
        ]);

    }
}
