<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Models\Admin\Category;
use App\Models\Admin\Gallary;
use App\Models\Admin\Lang;
use App\Models\Admin\Product;
use App\Models\ProductFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Admin\ProductProp;
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
        $query = Product::query();

        // Search by name
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->whereHas('translations', function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Get all categories for the filter
        $categories = Category::all();

        // Paginate products
        $products = $query->paginate(10); // Adjust number as needed

        return view('admin.products.index', [
            'langs' => $this->langs,
            'products' => $products,
            'categories' => $categories,
            'search' => $request->input('search'), // For keeping search term
            'selectedCategory' => $request->input('category_id') // For keeping selected category
        ]);
    }


    public function create()
    {
        $categories = Category::all();
        return view('admin.products.add' , ['categories' => $categories , 'langs'=> $this->langs]);

    }

    public function store(StoreProductRequest $request)
    {

//        if($this->check_sku($request->sku)){
//            Alert::error('error', 'Sku Already Used Before');
//            return redirect()->route('admin.products.index');
//        }

        try{
            DB::beginTransaction();
              $product =  new Product();
              $product->category_id = ($request->category != '0' ) ? $request->category : null;
              $product->price = $request->price;
              $product->old_price = $request->old_price;
              $product->discount = $request->discount;
              $product->star = $request->star;
              $product->sku  = $request->sku;
              $product->video = $request->video;
            foreach ($this->langs as $lang) {
                $product->{'name:'.$lang->code}  = $request->name[$lang->code];
                $product->{'des:'.$lang->code}  = $request->des[$lang->code];
                $product->{'meta_des:'.$lang->code}  = $request->meta_des[$lang->code];
                $product->{'meta_title:'.$lang->code}  = $request->meta_title[$lang->code];
                $product->{'slug:'.$lang->code}  = $request->slug[$lang->code];
            }
            $product->save();
            DB::commit();
            Alert::success('Success', 'Product Added Successfully !');
            return redirect()->back();

        }catch(\Exception $e){
            dd($e->getLine() , $e->getMessage());
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.products.index');

        }


    }

    public function update(StoreProductRequest $request , $id)
    {

//        if($this->check_sku($request->sku , $id)){
//            Alert::error('error', 'Sku Already Used Before');
//            return redirect()->route('admin.products.index');
//        }
        try {
            DB::beginTransaction();
            $product = Product::findOrFail($id);
            $product->update([
                'price'       =>        $request->price,
                'category_id' => $request->category,
                'star'       => $request->star,
                'old_price' => $request->old_price,
                'discount' => $request->discount,
                'sku'      =>$request->sku,
                'video'=>$request->video
            ]);
            foreach ($this->langs as $lang) {
                $product->{'name:'.$lang->code}  = $request->name[$lang->code];
                $product->{'des:'.$lang->code}  = $request->des[$lang->code];
                $product->{'meta_des:'.$lang->code}  = $request->meta_des[$lang->code];
                $product->{'meta_title:'.$lang->code}  = $request->meta_title[$lang->code];
                $product->{'slug:'.$lang->code}  = $request->slug[$lang->code];
            }

            $product->save();
            DB::commit();
            Alert::success('Success', 'Product Updated Successfully !');
            return redirect()->back();

        }catch (\Exception $e){
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.products.index');
        }

    }

    private function check_sku($sku , $id = null){
        // Check if SKU exists in the database, excluding the current product's ID if provided
        return Product::where('sku', $sku)
            ->when($id, function ($query) use ($id) {
                return $query->where('id', '!=', $id); // Exclude the current product ID
            })
            ->exists(); // Use exists() to return a boolean

    }


    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.update' , ['langs'=>$this->langs , 'categories'=> $categories , 'product'=>$product]);

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
        return view('admin.products.add_stock' , ['products'=>Product::all()]);
    }

    public function store_stock(Request $request){

        $request->validate([
            'product_id'=>'required|integer|exists:products,id',
            'stock'=>'required|numeric|min:0'

        ]);

        try{
            DB::beginTransaction();
            $product = Product::findOrFail($request->product_id);
            $product->stock += $request->stock;
            $product->save();
            DB::commit();
            Alert::success('Success', 'Product Gallery Added Successfully !');
            return redirect()->back();

        }catch(\Exception $e){
            dd($e->getLine() , $e->getMessage());
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->back();
        }

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

        Alert::success('Success', 'ile deleted successfully.');

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


}
