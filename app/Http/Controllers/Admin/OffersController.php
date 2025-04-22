<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Offers;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class OffersController extends Controller
{


    public function index(Request $request)
    {
        $query = Offers::with('product');
    
        // Handle product selection
        if ($request->has('product_id') && $request->product_id != '') {
            $query->where('product_id', $request->product_id);
        }
    
        // Handle search
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('product', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
    
        // Handle sorting
        if ($request->has('sort') && in_array($request->sort, ['latest', 'oldest'])) {
            $query->orderBy('created_at', $request->sort === 'latest' ? 'desc' : 'asc');
        }
    
        $offers = $query->get(); // Get the filtered and sorted offers
        $products = Product::all(); // Fetch all products
    
        return view('admin.offers.index', compact('offers', 'products'));
    }
    
    
        // Show the form for creating a new offer
        public function add()
        {
            $products = Product::all(); // Get all products to choose from
            return view('admin.offers.add', compact('products')); // Adjust the view path as necessary
        }
    
        // Store a newly created offer in storage
        public function store(Request $request)
        {
            $request->validate([
                'product_id' => 'required|exists:products,id', // Validate product_id
            ]);
    
            Offers::create($request->only('product_id')); // Store the new offer
            Alert::success('Success', 'Offer Added Successfully!');

            return redirect()->route('admin.offers.index');
        }

    

    
        // Remove the specified offer from storage
        public function delete($id)
        {
            $offer = Offers::findOrFail($id);
            $offer->delete(); // Delete the offer
            Alert::success('Success', 'Offer Deleted Successfully!');

            return redirect()->route('admin.offers.index');
        }

}
