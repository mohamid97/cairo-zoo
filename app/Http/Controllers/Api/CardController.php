<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddToCardRequest;
use App\Http\Requests\Admin\UpdateCardRequest;
use App\Http\Resources\Admin\UserCardResource;
use App\Models\Admin\Product;
use App\Models\Front\Card;
use App\Models\Front\CardItem;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CardController extends Controller
{
    use ResponseTrait;



    // addd new item to card
    public function add_item(AddToCardRequest $request){

        try{
            DB::beginTransaction();
            $user = $request->user();
            $card = Card::firstOrCreate(['user_id' => $user->id]);
            $cardItem = CardItem::where('card_id', $card->id)->where('product_id', $request->product_id)->first();  
            $product = Product::find($request->product_id);
            if(!isset($product)){
                return $this->res(false ,__('main.product_not_found') , 404);
            }
            if($product->stock < $request->quantity){
                return  $this->res(false ,__('main.stock_less_than_quantity'), 404);
            }
            if ($cardItem) {
                $cardItem->quantity += $request->quantity;
                $cardItem->save();
            } else {
                CardItem::create([
                    'card_id' => $card->id,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                ]);
            }
            DB::commit();
            $updatedCard = Card::with(['user' , 'items.product'])->find($card->id);

            return  $this->res(true , __('main.item_added_successfully') , 200 , new UserCardResource($updatedCard));
        }catch(\Exception $e){
            DB::rollBack();
            return  $this->res(false ,$e->getMessage() , $e->getCode());
        }





    } // end add to card




    public function get_user_card(Request $request){
       
        $user = $request->user();
        $card = Card::with(['user' , 'items.product'])->where('user_id', $user->id)->first();

        if (!$card) {
            return  $this->res(true , __('main.no_data_in_cart') , 200);
        }

        return  $this->res(true ,__('main.user_cart') , 200 , new UserCardResource($card));



    } // end get user card



      public function update(UpdateCardRequest $request)
      {
 
          try {
              DB::beginTransaction(); 
              $user = $request->user();
              $card = Card::with(['user' , 'items.product'])->where('user_id', $user->id)->first();
              $cardItem = CardItem::where('card_id', $card->id)->where('product_id', $request->product_id)->first();
              if (!$card && !$cardItem) {
                return  $this->res(true ,__('main.user_has_no_cart') , 404 , new UserCardResource($card));
              }

              // check increae or decrease or quantity
              if($request->type){

                    if ($request->type == 'increase') {
                        $cardItem->quantity += 1;
                        $cardItem->save();

                    } elseif ($request->type == 'decrease') {
                        $cardItem->quantity -= 1;
                        if ($cardItem->quantity < 1) {
                            $cardItem->delete();
                        } else {
                            $cardItem->save();
                        }
                    }


              }else if($request->quantity && $request->quantity > 0){ 
   
                    $cardItem->quantity = $request->quantity;
                    $cardItem->save();
               
              }else{
                    DB::rollBack(); 
                    return  $this->res(false ,__('main.no_type_or_quantity') , 404);
              }  // end check type or quantity
              DB::commit(); 
              $updatedCard = Card::with(['user' , 'items.product'])->where('user_id', $user->id)->first();
              return  $this->res(true ,__('main.user_cart'), 200 , new UserCardResource($updatedCard));
  
          }catch(\Exception $e) {
              DB::rollBack(); 
              return  $this->res(false ,$e->getMessage() , $e->getCode());

          }




      } //finsh the update cart




      public function delete(Request $request){
            try {
                DB::beginTransaction(); 
                $user = $request->user();
                $card = Card::where('user_id', $user->id)->first();

                if (!$card) {
                    return  $this->res(false ,__('main.user_has_no_cart') , 404);
                }
                $card->items()->delete();
                $card->delete();
                DB::commit(); 
                return  $this->res(true , __('main.cart_deleted') , 200);

            } catch (\Exception $e) {
                DB::rollBack();
                return  $this->res(false ,$e->getMessage() , $e->getCode());

            }
      } // end delete user card


     
public function delete_card_item(Request $request)
{
    try {
      
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        DB::beginTransaction(); 

        $user = $request->user();
        $card = Card::with(['user', 'items.product'])->where('user_id', $user->id)->first();

        if (!$card) {
            return $this->res(true, __('main.user_has_no_cart'), 404);
        }

        $cardItem = CardItem::where('card_id', $card->id)
                            ->where('product_id', $request->product_id)
                            ->first();

        if (!$cardItem) {
            return $this->res(true, __('main.product_not_found_in_cart'), 404);
        }

        $cardItem->delete();

        if ($card->items()->count() === 0) {
            $card->delete();
        }

        DB::commit();
        return $this->res(true, __('main.cart_item_deleted'), 200, new UserCardResource($card));

    } catch (ValidationException $e) {
        return $this->res(false, $e->errors(), 422);

    } catch (\Exception $e) {
        DB::rollBack(); 
        return $this->res(false, $e->getMessage(), $e->getCode() ?: 500);
    }
}




      


      




}
