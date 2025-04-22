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

class CardController extends Controller
{
    use ResponseTrait;



    // addd new item to card
    public function add_item(AddToCardRequest $request){

        try{
            DB::beginTransaction();
            $user = $request->user();
            // Find or create a card for the user
            $card = Card::firstOrCreate(['user_id' => $user->id]);
            // Check if the item already exists in the cart
            $cardItem = CardItem::where('card_id', $card->id)->where('product_id', $request->product_id)->first();  
            // check stock card
            $product = Product::find($request->product_id);
            if($product->stock <= 0){
                return  $this->res(false ,'No Stock For This Product' , 404);
            }
            if ($cardItem) {
                // If item exists, update the quantity
                $cardItem->quantity += 1;
                $cardItem->save();
            } else {
                // If item does not exist, create a new one
                CardItem::create([
                    'card_id' => $card->id,
                    'product_id' => $request->product_id,
                    'quantity' => 1,
                ]);
            }
    
            DB::commit();
                    // Fetch the updated card with its items
            $updatedCard = Card::with(['user' , 'items.product'])->find($card->id);
            return  $this->res(true ,'Item Added Successfully !' , 200 , new UserCardResource($updatedCard));
        }catch(\Exception $e){
            DB::rollBack();
            return  $this->res(false ,$e->getMessage() , $e->getCode());
        }





    } // end add to card

    // get user card 
    public function get_user_card(Request $request){
       
        // Get the authenticated user
        $user = $request->user();
        // Find the user's card
        $card = Card::with(['user' , 'items.product'])->where('user_id', $user->id)->first();

        // Check if the card exists
        if (!$card) {
            return  $this->res(true ,'No Data In Cart' , 200);

        }

        return  $this->res(true ,'User Cart !' , 200 , new UserCardResource($card));



    }


    // start update card 
      // Method to update the user's card
      public function update(UpdateCardRequest $request)
      {
 
          try {
              DB::beginTransaction(); // Start the transaction
  
              // Get the authenticated user
              $user = $request->user();
              // Find the user's card
              $card = Card::with(['user' , 'items.product'])->where('user_id', $user->id)->first();
              $cardItem = CardItem::where('card_id', $card->id)->where('product_id', $request->product_id)->first();

              // Check if the card exists
              if (!$card && !$cardItem) {
                return  $this->res(true ,'User Has No Cart Or No Item In Card !' , 404 , new UserCardResource($card));
              }

              // check if type has data 
              if($request->type){

                    if ($request->type == 'increase') {
                        // Increase the quantity by 1
                        $cardItem->quantity += 1;
                        $cardItem->save();

                    } elseif ($request->type == 'decrease') {
                        $cardItem->quantity -= 1;
                        // If quantity drops below 1, remove the item from the card
                        if ($cardItem->quantity < 1) {
                            $cardItem->delete();
                        } else {
                            $cardItem->save();
                        }
                    }


              }else{ // end if fore type
                    if($request->quantity){
                        $cardItem->quantity = $request->quantity;
                        $cardItem->save();
                    }
              }  
              DB::commit(); // Commit the transaction
              // Return the updated card data
              $updatedCard = Card::with(['user' , 'items.product'])->where('user_id', $user->id)->first();
              return  $this->res(true ,'User Cart !' , 200 , new UserCardResource($updatedCard));
  
          }catch(\Exception $e) {
              DB::rollBack(); // Rollback the transaction in case of an error
              return  $this->res(false ,$e->getMessage() , $e->getCode());


          }




      } //finsh the update cart



      // delete cart
      public function delete(Request $request){
            try {
                DB::beginTransaction(); // Start the transaction

                // Get the authenticated user
                $user = $request->user();

                // Find the user's card
                $card = Card::where('user_id', $user->id)->first();

                // Check if the card exists
                if (!$card) {
                    return  $this->res(true ,'User Has No Cart !' , 404);

                }

                // Delete all items from the user's card
                $card->items()->delete();
                $card->delete();

                DB::commit(); // Commit the transaction
                return  $this->res(true ,'User Cart Deleted !' , 200);

            } catch (\Exception $e) {
                DB::rollBack(); // Rollback the transaction in case of an error
                return  $this->res(false ,$e->getMessage() , $e->getCode());

            }
      } // end delete user card


      // delete special item from card 
      public function delete_card_item(Request $request){
            $request->validate([
                'product_id' => 'required|exists:products,id',
            ]);
            try {
                DB::beginTransaction(); // Start the transaction
                // Get the authenticated user
                $user = $request->user();
                // Find the user's card
                $card = Card::with(['user' , 'items.product'])->where('user_id', $user->id)->first();
                // Check if the card exists
                if (!$card) {
                    return  $this->res(true ,'User Has No Cart !' , 404);
                }
                // Find the specific item in the card
                $cardItem = CardItem::where('card_id', $card->id)->where('product_id', $request->product_id)->first();
                // Check if the item exists in the card
                if (!$cardItem) {
                    return  $this->res(true ,'Product Not Founded In Cart!' , 404);
                }
                // Delete the item
                $cardItem->delete();
                // Check if the card is now empty and delete the card if so
                if ($card->items()->count() === 0) {
                    $card->delete();
                }
                DB::commit(); // Commit the transaction
                return  $this->res(true ,'User Cart Item Deleted !' , 200 , new UserCardResource($card));
            } catch (\Exception $e) {
                DB::rollBack(); // Rollback the transaction in case of an error
                return  $this->res(false ,$e->getMessage() , $e->getCode());

            }
      
      } // end felete item form card


      




}
