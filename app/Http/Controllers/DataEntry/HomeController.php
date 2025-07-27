<?php

namespace App\Http\Controllers\DataEntry;

use App\Http\Controllers\Controller;
use App\Models\Admin\Brand;
use App\Models\Admin\Category;
use App\Models\Admin\Cms;
use App\Models\Admin\Coupon;
use App\Models\Admin\Lang;
use App\Models\Admin\MediaGroup;
use App\Models\Admin\Message;
use App\Models\Admin\Product;
use App\Models\Admin\Service;
use App\Models\Admin\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // index method
    public function index(){

        $messages   = Message::count();
        $categories = Category::count();
        $products   = Product::withoutGlobalScope('inStock')->count();
        $services   = Service::count();
        $blogs       = Cms::count();
        $media_group = MediaGroup::count();
        $sliders     = Slider::count();
        $brands      = Brand::count();
        $coupons     = Coupon::where('is_active', 1)->whereDate('start_date', '<=', Carbon::now())->whereDate('end_date', '>=', Carbon::now())->count();
        return view('data_entry.home.index' , [
            'messages' => $messages,
            'categories' => $categories,
            'products' => $products,
            'services' => $services,
            'blogs' => $blogs,
            'media_group' => $media_group,
            'sliders' => $sliders,
            'brands' => $brands,
            'coupons' => $coupons
        ]);

    }
}
