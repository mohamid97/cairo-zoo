<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Models\Admin\Brand;
use App\Models\Admin\Category;
use App\Models\Admin\Gallary;
use App\Models\Admin\Lang;
use App\Models\Admin\Product;
use App\Models\ProductFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Admin\ProductProp;
use App\Models\Admin\Stock;
use App\Models\Admin\Taste;
class ProductController extends Controller
{
    protected $langs;
    public function __construct()
    {
        $this->langs = Lang::all();
    }

    //
    public function index(Request $request)
    {
        $query = Product::withoutGlobalScope('inStock')->with('brand');

        // Search by name
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->whereHas('translations', function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->input('brand_id'));
        }



        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Get all categories for the filter
        $categories = Category::all();
        $brands = Brand::all();
        // Paginate products
        $products = $query->paginate(10); // Adjust number as needed

        return view('admin.products.index', [
            'langs' => $this->langs,
            'products' => $products,
            'categories' => $categories,
            'search' => $request->input('search'),
            'selectedCategory' => $request->input('category_id'),
             'brands' => $brands,
            'selectedBrand' => $request->input('brand_id'),
        ]);
    }


    public function create()
    {
        $categories = Category::all();
        return view('admin.products.add' , ['tastes'=>Taste::all() ,'categories' => $categories , 'langs'=> $this->langs , 'brands'=> Brand::all() , 'products'=>Product::all()]);

    }


    public function store(StoreProductRequest $request)
    {


        try{
            DB::beginTransaction();
            $imageData = [];
            if ($request->hasFile('image')) {
                $imageData['image'] = $this->upload_image($request->file('image'));
            }
            if ($request->hasFile('thumbinal')) {
                $imageData['thumbinal'] = $this->upload_image($request->file('thumbinal'));
            }

          
            $product = Product::create([
                'weight' => $request->weight,
                'length' => $request->length,
                'height' => $request->height,
                'width'  => $request->width,
                'status' => $request->status ?? 'pending',
                'brand_id' => $request->brand_id,
                'sales_price' => $request->sales_price,
                'video' => $request->video,
                'category_id'=>$request->category_id,
                'sku' => $request->sku,
                'image' => $imageData['image'] ?? null,
                'thumbinal' => $imageData['thumbinal'] ?? null,
                'barcode'=>$request->barcode,
                'taste_id'=>$request->taste_id
            ]);

            foreach ($this->langs as $lang) {
                $product->{'name:'.$lang->code}  = $request->name[$lang->code];
                $product->{'des:'.$lang->code}  = $request->des[$lang->code];
                $product->{'meta_des:'.$lang->code}  = $request->meta_des[$lang->code];
                $product->{'small_des:'.$lang->code}  = $request->meta_des[$lang->code];
                $product->{'meta_title:'.$lang->code}  = $request->meta_title[$lang->code];
                $product->{'slug:'.$lang->code}  = $request->slug[$lang->code];
            }

            $product->save();
            $product->relatedProducts()->sync($request->related_products);

            DB::commit();
            Alert::success('Success', __('main.product_added_successfully'));
            return redirect()->back();

        }catch(\Exception $e){
            dd($e->getLine() , $e->getMessage());
            DB::rollBack();
            Alert::error('error', __('main.programer_error'));
            return redirect()->route('admin.products.index');

        }


    }



    public function edit($id)
    {
        $product = Product::with(['relatedProducts', 'translations'])->withoutGlobalScope('inStock')->findOrFail($id);

        $categories = Category::all();
        $brands = Brand::all();
        $products = Product::where('id', '!=', $id)->get();

        return view('admin.products.update', [
            'langs' => $this->langs,
            'categories' => $categories,
            'brands' => $brands,
            'products' => $products,
            'product' => $product,
            'tastes'=>Taste::all() 
        ]);
    }


    public function update(StoreProductRequest $request , $id)
    {

      
        try {
            DB::beginTransaction();
            $product = Product::withoutGlobalScope('inStock')->findOrFail($id);
            $imageData = [];
            if ($request->hasFile('image')) {
                $imageData['image'] = $this->upload_image($request->file('image'));
            }
            if ($request->hasFile('thumbinal')) {
                $imageData['thumbinal'] = $this->upload_image($request->file('thumbinal'));
            }


            $product->update([
                'weight' => $request->weight,
                'length' => $request->length,
                'height' => $request->height,
                'width'  => $request->width,
                'status' => $request->status,
                'brand_id' => $request->brand_id,
                'sales_price' => $request->sales_price,
                'video' => $request->video,
                'sku' => $request->sku,
                'image' => $imageData['image'] ?? $product->image,
                'thumbinal' => $imageData['thumbinal'] ?? $product->thumbinal,
                'barcode'=>$request->barcode,
                'taste_id'=>$request->taste_id,
                'category_id'=>$request->category_id,

            ]);
            foreach ($this->langs as $lang) {
                $product->{'name:'.$lang->code}  = $request->name[$lang->code];
                $product->{'des:'.$lang->code}  = $request->des[$lang->code];
                $product->{'meta_des:'.$lang->code}  = $request->meta_des[$lang->code];
                $product->{'small_des:'.$lang->code}  = $request->meta_des[$lang->code];
                $product->{'meta_title:'.$lang->code}  = $request->meta_title[$lang->code];
                $product->{'slug:'.$lang->code}  = $request->slug[$lang->code];
            }
            $product->save();
           $product->relatedProducts()->sync($request->related_products);

            DB::commit();
            Alert::success('Success', __('main.product_updated_successfully'));
            return redirect()->back();

        }catch (\Exception $e){
            DB::rollBack();
            Alert::error('error', __('main.delete_Product_warning'));
            return redirect()->route('admin.products.index');
        }

    }

    // upload image and thumbinal
    private function upload_image($image)
    {
        $image_name = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('uploads/images/products'), $image_name);
        return $image_name;
    }




    private function check_sku($sku , $id = null){
        // Check if SKU exists in the database, excluding the current product's ID if provided
        return Product::where('sku', $sku)
            ->when($id, function ($query) use ($id) {
                return $query->where('id', '!=', $id); // Exclude the current product ID
            })
            ->exists(); // Use exists() to return a boolean

    }



    public function gallery($id){
        $product = Product::with('gallery')->findOrFail($id);
        return view('admin.products.Gallary' , ['product'=>$product]);
    }


    public function store_gallery(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validate multiple images
        $request->validate([
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Validate each photo
        ]);

        // Check if the request has files
        if ($request->has('photos')) {
            foreach ($request->file('photos') as $photo) {
                $image_name = time() . '_' . $photo->getClientOriginalName();
                $photo->move(public_path('uploads/images/gallery'), $image_name);

                // Save each image in the gallery table
                $gallery = new Gallary();
                $gallery->product_id = $product->id;
                $gallery->photo = $image_name;
                $gallery->save();
            }

            Alert::success('Success', 'Product Gallery Added Successfully!');
            return redirect()->back();
        }

         Alert::error('Error', 'No files uploaded. Please try again.');
         return redirect()->back();
    }




    public function delete_gallery($id){

        try {
            DB::beginTransaction();
            $gallery = Gallary::findOrFail($id);
            if (isset($gallery->photo) &&file_exists(public_path('uploads/images/gallery/' .$gallery->photo))) {
                unlink(public_path('uploads/images/gallery/' .$gallery->photo));
            }
            $gallery->delete();
            DB::commit();
            Alert::success('Success', 'Product Gallery Added Successfully !');
            return redirect()->back();

        }catch (\Exception $e){
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.products.index');
        }

    }


    public function add_stock(){
        return view('admin.products.add_stock' , ['products'=>Product::withoutGlobalScope('inStock')->get()]);
    }

    public function store_stock(Request $request){

        $request->validate([
            'product_id'=>'required|integer|exists:products,id',
            'quantity'=>'required|numeric|min:1',
            'cost_price'=>'required|numeric|min:1',
            'sales_price'=>'required|numeric|min:1'

        ]);

        try{
            DB::beginTransaction();
            $product = Product::withoutGlobalScope('inStock')->findOrFail($request->product_id);
            $product->update(['sales_price'=>$request->sales_price , 'stock'=> $product->stock + $request->quantity ]);
            $product->stocks()->create([
                'quantity'    => $request->quantity,
                'cost_price'  => $request->cost_price,
                'sales_price' => $request->sales_price
            ]);
            DB::commit();
            Alert::success('Success', __('main.product_stock_added'));
            return redirect()->back();

        }catch(\Exception $e){
            dd($e->getLine() , $e->getMessage());
            DB::rollBack();
            Alert::error('error', __('main.programer_error'));
            return redirect()->back();
        }

    }

    public function update_movement(Request $request){
        try{
            DB::beginTransaction();
            $stock = Stock::with('product')->findOrFail($request->stock_id);
            
            $stock->product->update(['stock'=> $stock->product->stock - $stock->quantity ]);
            $stock->update([
                'quantity'    => $request->quantity,
            ]);
            $stock->product->update(['stock'=> $stock->product->stock + $request->quantity ]);
            DB::commit();
            Alert::success('Success', __('main.product_stock_added'));
            return redirect()->back();

        }catch(\Exception $e){
            //dd($e->getLine() , $e->getMessage());
            DB::rollBack();
            Alert::error('error', __('main.programer_error'));
            return redirect()->back();
        }
    }

    public function delete_movement($id){
        $stock = Stock::with('product')->findOrFail($id);
        $stock->product->update(['stock' => $stock->product->stock - $stock->quantity]);
        $stock->delete();
        Alert::success('Success', __('main.stock_deleted'));
        return redirect()->back();


    }

    public  function files($id){

        return view('admin.products.show_files' , ['product'=>Product::with('files')->findOrFail($id)]);

    }

    // store files
    public function store_file($id, Request $request)
    {
        // Validate the file input
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', // adjust the file types and size limit as needed
            'file_name'=>'required|string|max:255'
        ]);

        // Retrieve the product by ID
        $product = Product::findOrFail($id);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = 'uploads/images/products/'; // Define the path where the file will be stored

            // Move the file to the specified directory
            $file->move(public_path($filePath), $filename);


            $product->files()->create([
                'name' => $request->file_name,
                'file' => $filename,
            ]);
        }

        Alert::success('Success', 'File uploaded successfully.');

        // Redirect back with a success message
        return redirect()->route('admin.products.files', ['id' => $id]);

    }



    public function delete_file($id)
    {
        // Find the file by its ID
        $file = ProductFile::findOrFail($id);

        // Delete the file from storage
        $filePath = asset('uploads/images/products/'.$file->file);
        if (file_exists($filePath)) {
            unlink($filePath); // Remove the file from the filesystem
        }

        // Delete the file record from the database
        $file->delete();

        Alert::success('Success', 'File deleted successfully.');

        // Redirect back with a success message
        return redirect()->back();
    }




    public  function props($id){
        return view('admin.products.props' , ['product'=>Product::with('props')->findOrFail($id) , 'langs' =>$this->langs]);

   }


   public  function store_prop(Request $request , $id){

       // Validate the file input
       $request->validate([
           'name.*' => 'required|max:255',
           'value.*'=>'required|string|max:5000'
       ]);

       // Retrieve the product by ID
       $product = Product::findOrFail($id);
       $prop = ProductProp::create([
           'product_id'=>$product->id,
           'status' => 1
       ]);

       foreach ($this->langs as $lang) {
        $prop->{'name:'.$lang->code}= $request->name[$lang->code];
        $prop->{'value:'.$lang->code} = $request->value[$lang->code];
    }

       $prop->save();
       Alert::success('Success', 'Props Stored Successfully !');

       // Redirect back with a success message
       return redirect()->back();


   }


   public  function delete_prop($id){
       // Find the file by its ID
       $prop = ProductProp::findOrFail($id);

       // Delete the file record from the database
       $prop->delete();
       Alert::success('Success', 'Prop deleted successfully.');

       // Redirect back with a success message
       return redirect()->back();
   }



    public  function destroy($id){
        $product = Product::withTrashed()->findOrFail($id);
        $product->forceDelete(); // Permanently deletes the product
        Alert::success('Success', 'Product deleted successfully.');
        return redirect()->back();
    }

    public function restore($id){
        $product = Product::withTrashed()->findOrFail($id);
        if ($product->trashed()) {

            $product->restore(); // Restores the soft-deleted product
            Alert::success('Success', 'Product Restored successfully.');
            return redirect()->back();
        }
        Alert::error('Success', 'Can not  Restored Product.');
        return redirect()->back();
    }

    public  function soft_delete($id){
        $product = Product::findOrFail($id);
        $product->delete(); // Soft deletes the product
        Alert::error('Success', 'Soft Deleted Successfully !.');
        return redirect()->back();

    }

    public function stock_movement($id){
        $product = Product::with('stocks')->findOrFail($id);
        return view('admin.products.stock_movement' , ['product'=>$product]);
    }

    public function edit_movement($id){
        return view('admin.products.edit_stock_movement' , ['stock_movemnt'=> Stock::with('product')->findOrFail($id)]);
    }


}