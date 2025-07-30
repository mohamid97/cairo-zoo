<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ProductDetailsResource;
use App\Http\Resources\Admin\ProductResource;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ResponseTrait;

    public function paginate( Request $request){

        $query = Product::query();
        if($request->has('product_name')){
            $query->where('sku' , 'LIKE', '%' . $request->product_name . '%')
                ->OrWhere('barcode' , 'LIKE', '%' . $request->product_name . '%' )
            ->OrwhereHas('translations', function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->product_name . '%');
            });

        }


        if ($request->has('category_slug')) {

            $query->whereHas('category', function($q) use ($request) {
                // Check the slug within the translations
                $q->whereHas('translations', function ($translationQuery) use ($request) {
                    $translationQuery->where('slug', $request->category_slug);
                });
            });
        }


        if ($request->has('brand_slug')) {

            $query->whereHas('brand', function($q) use ($request) {
                // Check the slug within the translations
                $q->whereHas('translations', function ($translationQuery) use ($request) {
                    $translationQuery->where('slug', $request->brand_slug);
                });
            });
        }

        if ($request->has('min_price') && $request->has('max_price')) {
            $minPrice = $request->min_price;
            $maxPrice = $request->max_price;

            if (is_numeric($minPrice) && is_numeric($maxPrice)) {
               $query->whereRaw('CAST(sales_price AS DECIMAL(8, 2)) BETWEEN ? AND ?', [$minPrice, $maxPrice]);
            }

        }


        // filter by product has discount (discounts in table discounts with type = product )
        if ($request->has('discount') && $request->discount == 'YES') {
            $query->whereHas('discounts', function($q) use ($request) {
                $q->where('type', 'product');
            });
        }

        // filter with sorted by asc or desc
        if ($request->has('sort')) {
            $sort = $request->sort;
            switch ($sort) {
                case 'asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'desc':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'low_price':
                    $query->orderByRaw('CAST(sales_price AS DECIMAL(8, 2)) asc');
                    break;
                case 'high_price':
                    $query->orderByRaw('CAST(sales_price AS DECIMAL(8, 2)) desc');
                    break;
                default:
                    $query->orderBy('created_at', 'asc');
                    break;
            }
        }



        $products = $query->paginate(10);
        return  $this->res(true ,'All Products with paginate' , 200 , [

            'products' => ProductResource::collection($products),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'last_page' => $products->lastPage(),
                'next_page_url' => $products->nextPageUrl(),
                'prev_page_url' => $products->previousPageUrl(),
            ],


        ]);
    }

    public function get_product_details(Request $request) {
        $productdetails = Product::whereHas('translations', function ($query) use($request) {
            $query->where('slug' , $request->slug);
        })->first();

        if(optional($productdetails)->exists()){
            return  $this->res(true ,'product Details' , 200 , new ProductDetailsResource($productdetails));
        }

        return  $this->res(false ,__('main.product_details_not_found') , 404);
    }



    // public function get()
    // {
    //     $products = Product::whereHas('translations', function ($query) {
    //         $query->where('locale', '=', app()->getLocale());
    //     })->orderBy('updated_at' , 'desc')->get();
    //     return  $this->res(true ,'All Products' , 200 , ProductResource::collection($products));
    // }


    // // general filter
    // public function getFilteredProducts(Request $request)
    // {

    //     // Initialize the query
    //     $query = Product::query();



    //     // Filter by category slug if provided
    //     if ($request->has('category_slug') && $request->category_slug) {

    //         $query->whereHas('category', function($q) use ($request) {
    //             // Check the slug within the translations
    //             $q->whereHas('translations', function ($translationQuery) use ($request) {
    //                 $translationQuery->where('slug', $request->category_slug)
    //                                  ->where('locale', app()->getLocale());
    //             });
    //         });
    //     }

    //     // Filter by product name if provided
    //     if ($request->has('product_name')) {

    //         $query->whereHas('translations', function ($q) use ($request) {
    //             $q->where('locale', app()->getLocale())
    //                 ->where('name', 'like', '%' . $request->product_name . '%');
    //         });
    //     }



    //     // Filter by price range if min and max prices are provided
    //     if ($request->has('min_price') && $request->has('max_price')) {

    //         $minPrice = $request->min_price;
    //         $maxPrice = $request->max_price;

    //         if (is_numeric($minPrice) && is_numeric($maxPrice)) {
    //             $query->whereRaw('CAST(price AS DECIMAL(10, 2)) BETWEEN ? AND ?', [$minPrice, $maxPrice]);
    //         }
    //     } elseif ($request->has('min_price')) {
    //         if (is_numeric($request->min_price)) {
    //             $query->whereRaw('CAST(price AS DECIMAL(10, 2)) >= ?', [$request->min_price]);
    //         }
    //     } elseif ($request->has('max_price')) {
    //         if (is_numeric($request->max_price)) {
    //             $query->whereRaw('CAST(price AS DECIMAL(10, 2)) <= ?', [$request->max_price]);
    //         }
    //     }



    //     // Apply sorting
    //     if ($request->has('sort')) {

    //         $sort = $request->sort;

    //         switch ($sort) {
    //             case 'asc':
    //                 $query->orderBy('id', 'asc'); // Assuming 'name' is the column you want to sort alphabetically
    //                 break;
    //             case 'desc':
    //                 $query->orderBy('id', 'desc');
    //                 break;
    //             case 'low_price':
    //                 $query->orderByRaw('CAST(price AS DECIMAL(10, 2)) asc');
    //                 break;
    //             case 'high_price':
    //                 $query->orderByRaw('CAST(price AS DECIMAL(10, 2)) desc');
    //                 break;
    //             default:
    //                 // Default sorting if no valid sort option is provided
    //                 $query->orderBy('id', 'asc');
    //                 break;
    //         }
    //     }

    //     // Fetch filtered and sorted products with pagination
    //     $products = $query->paginate(10);

    //     return $this->res(true, 'Filtered and Sorted Products', 200, ['products'=> ProductResource::collection($products)  ,     'pagination' => [
    //         'current_page' => $products->currentPage(),
    //         'last_page' => $products->lastPage(),
    //         'per_page' => $products->perPage(),
    //         'total' => $products->total(),
    //         'next_page_url' => $products->nextPageUrl(),
    //         'prev_page_url' => $products->previousPageUrl(),
    //     ]]);
    // }



    // // filter with category id and product name
    // public function filter_product_name_category(Request $request)
    // {
    //     // Initialize the query
    //     //$query = Product::query();

    //     // Filter by category ID if provided
    //     // if ($request->has('category_id') && $request->category_id) {
    //     //     $query->where('category_id', $request->category_id);
    //     // }

    //     // Filter by product name if provided
    //     // if ($request->has('name') && $request->name) {
    //     //     $query->whereHas('translations', function ($q) use ($request) {
    //     //         $q->where('locale', app()->getLocale())
    //     //           ->where('name', 'like', '%' . $request->name . '%');
    //     //     });
    //     // }

    //     // Fetch the filtered products with pagination (optional)
    //     // $products = $query->paginate(25);

    //     // return $this->res(true, 'Filtered Products', 200, ProductResource::collection($products));
    // }


    // public function products_category(Request $request)
    // {
    //     $request->validate([
    //         'slug' => "required",
    //     ]);
    //     try {
    //         $category = Category::whereHas('translations', function ($query) use ($request) {
    //             $query->where('locale', '=', app()->getLocale())->where('slug', $request->slug);
    //         })->first();

    //         if ($category) {
    //             $categoryIds = $this->getAllCategoryIds($category);
    //             $products = Product::whereIn('category_id', $categoryIds)->get();

    //             return $this->res(true, 'Products fetched successfully', 200, ProductResource::collection($products));
    //         }

    //         return $this->res(false, 'No Category Found', 404);
    //     } catch (\Exception $e) {
    //         return $this->res(false, $e->getMessage(), $e->getCode(), $e->getLine());
    //     }
    // }

    // private function getAllCategoryIds($category)
    // {
    //     $ids = [$category->id];

    //     foreach ($category->children as $child) {
    //         $ids = array_merge($ids, $this->getAllCategoryIds($child));
    //     }

    //     return $ids;
    // }







}
