<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CategoryDetailsResource;
use App\Http\Resources\Admin\CategoryResource;
use App\Http\Resources\Admin\ParentChildCategoryResource;
use App\Models\Admin\Category;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ResponseTrait;
    //

    public function paginate()
    {
        $categories = Category::whereHas('translations', function ($query) {
            $query->where('locale', '=', app()->getLocale());
        })->orderBy('updated_at' , 'desc')->paginate(15);

        return $this->res(true, 'All Categories', 200, [
            'categories' => CategoryResource::collection($categories),
            'pagination' => [
                'current_page' => $categories->currentPage(),
                'per_page' => $categories->perPage(),
//                'total' => $categories->total(),
                'last_page' => $categories->lastPage(),
                'next_page_url' => $categories->nextPageUrl(),
                'prev_page_url' => $categories->previousPageUrl(),
            ],
        ]);

    }




    public function get()
    {
        $categories = Category::whereHas('translations', function ($query) {
            $query->where('locale', '=', app()->getLocale());
        })->orderBy('updated_at' , 'desc')->get();
        return  $this->res(true ,'All Categories ' , 200 ,CategoryResource::collection($categories));

    }


    public function get_details(Request $request){


        $category_details = Category::whereHas('translations', function ($query) use($request) {
            $query->where('locale', '=', app()->getLocale())->where('slug' , $request->slug);
        })->first();

        if(optional($category_details)->exists()){
            return  $this->res(true ,'Category Details' , 200 , new CategoryDetailsResource($category_details));
        }

        return  $this->res(false ,'Category details not found. Maybe there is no data with this slug or no data in this language.' , 404);



    }



    // return categories with products
    public function categories_with_products(){
        $categories = Category::with('products')->get();
        return $this->res(true , 'Categories with products' , 200 , CategoryResource::collection($categories));

    }


    // get parent categories
    public function get_parent_categories(){
        $categories = Category::where('parent_id' , null)->get();
        return $this->res(true , 'Parent Categories' , 200 , CategoryResource::collection($categories));

    }

    // get child categories
    public function get_sub_categories(){
        $categories = Category::where('parent_id' , '!=' , null)->get();
        return $this->res(true , 'Child Categories' , 200 , CategoryResource::collection($categories));

    }


    // get parent categories with child categories with unlimtied depth
    public function get_parent_categories_with_child(){
        $categories = Category::where('parent_id' , null)->with('children')->get();
        return $this->res(true , 'Parent Categories with child categories' , 200 , ParentChildCategoryResource::collection($categories));

    }




}
