<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\WishlistResource;
use App\Models\Admin\Wishlist;
use App\Models\Admin\WishlistItems;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    use ResponseTrait;
    public function index(Request $request)
    {
        $wishlist = Wishlist::where('user_id', $request->user()->id)->first();
        if($wishlist){
            return $this->res(true , 'User Wishlist' , 200 , new WishlistResource($wishlist->load(['user' , 'items.product'])));

        }

        return $this->res(false , 'No Wishlist For This User' , 404 );


    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
        try {
            DB::beginTransaction();
            $user = $request->user();
            $wishlist = Wishlist::firstOrCreate(['user_id' => $user->id]);
            $wishlistItem = WishlistItems::where('wishlist_id', $wishlist->id)
                ->where('product_id', $request->product_id)
                ->first();

            if (!$wishlistItem) {
                WishlistItems::create([
                    'wishlist_id' => $wishlist->id,
                    'product_id' => $request->product_id,
                ]);
            }

            DB::commit();

           return  $this->res(true , 'User Wishlist' , 200 , new WishlistResource($wishlist->load(['user' , 'items.product'])));

        } catch (\Exception $e) {
            DB::rollBack();
             return  $this->res(false ,$e->getMessage() , $e->getLine());

        }
    }

    public function delete(Request $request)
    {
        $user = $request->user();

        // Fetch the user's wishlist
        $wishlist = Wishlist::where('user_id', $user->id)->first();


        if (!$wishlist) {
            return  $this->res(true , __('main.no_wishlist') , 404);
        }


        // Now fetch the wishlist item based on the retrieved wishlist ID
        $wishlistItem = WishlistItems::where('wishlist_id', $wishlist->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            return  $this->res(true , __('main.wishlist_deleted') , 200 ,  new WishlistResource($wishlist->load(['user' , 'items.product'])));
        }

        return  $this->res(true , __('main.wishlist_not_found') , 404);
    }

}
