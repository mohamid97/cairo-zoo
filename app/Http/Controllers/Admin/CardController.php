<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Front\Card;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CardController extends Controller
{
    //card controller 
    public function get(Request $request)
    {
        // Query to load cards with relationships
        $query = Card::with(['user', 'items.product']); // Include product in the items relationship


        // Apply filters based on request input
        if ($request->has('first_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->first_name . '%');
            });
        }

        if ($request->has('last_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('last_name', 'like', '%' . $request->last_name . '%');
            });
        }

        if ($request->has('product_name')) {
            $query->whereHas('items.product', function ($q) use ($request) {
                //$q->where('name', 'like', '%' . $request->product_name . '%');
                $q->whereHas('translations', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->product_name . '%');
                });
            });
        }

        // Pagination
        $carts = $query->paginate(10); // Paginate 10 items per page

        return view('admin.cards.index', compact('carts'));
    }




    public function delete($id)
    {
        try {
            // Find the card by ID
            $card = Card::findOrFail($id);

            // If the card exists, delete it
            if ($card) {
                $card->delete();
                Alert::success('Success', 'Deleted Successfully ! !');
                return redirect()->route('admin.cards.index');
            }
            Alert::error('error', 'No Card Founded');
            // If card does not exist, return with an error message
            return redirect()->back();

        } catch (\Exception $e) {
            Alert::error('error', 'Tell The Programmer To solve Error');
            // Redirect back with an error message
            return redirect()->back();
        }
    } // end delete card



    public function showDetails($id)
    {
        try {
            // Find the card by ID
            $cart = Card::with(['user', 'items.product'])->findOrFail($id);

            // Calculate total price and total quantity
            $total_price = $cart->items->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            $total_quantity = $cart->items->sum('quantity');

            // Pass the data to the view
            return view('admin.cards.show_details', compact('cart', 'total_price', 'total_quantity'));

        } catch (\Exception $e) {
            dd($e->getMessage() , $e->getLine());
            // Log the error and return with a message
            \Log::error('Error fetching card details: ' . $e->getMessage());
            return redirect()->route('admin.cards.index')->with('error', __('An error occurred while trying to fetch the card details.'));
        }
    }








}
