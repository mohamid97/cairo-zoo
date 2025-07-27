<?php

namespace App\Http\Controllers;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadExcel extends Controller
{
    public function index(){
        $category = Category::all();
        return view('excel.index' , ['cats' => $category]);
    }
    public function upload(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'excel_file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $categoryId = $request->category_id;
        $file = $request->file('excel_file');

        // Save the file temporarily
        $path = $file->storeAs('temp', uniqid() . '.' . $file->getClientOriginalExtension());

        $fullPath = storage_path('app/' . $path);

        // Open file
        if (($handle = fopen($fullPath, 'r')) === false) {
            return response()->json(['error' => 'Unable to open file.'], 500);
        }

        $header = fgetcsv($handle); // Read the first row (header)

        $requiredHeaders = ['category_ar', 'category_en', 'arabic_name', 'english_name','sku' , 'cost_price' , 'sales_price'];
        $normalizedHeader = array_map(fn($h) => strtolower(trim($h)), $header);

//        dd($normalizedHeader);
//        dd(array_diff($requiredHeaders, $normalizedHeader));
//        // Validate header
//        if (array_diff($requiredHeaders, $normalizedHeader)) {
//            fclose($handle);
//            Storage::delete($path);
//            return response()->json(['error' => 'Invalid file format. Required: arabic_name, english_name, price'], 422);
//        }

        // Get indexes dynamically
        $indexMap = array_flip($normalizedHeader);

        dd($indexMap);
        $importedCount = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 3) continue;

            $arabicName  = trim($row[$indexMap['arabic_name']]);
            $englishName = trim($row[$indexMap['english_name']]);
            $price       = floatval(str_replace(['٫', ','], ['.', '.'], $row[$indexMap['sales_price']]));


            $product = new Product([
                'price' => $price,
                'category_id' => $categoryId,
            ]);

            $product->translateOrNew('ar')->name = $arabicName;
            $product->translateOrNew('ar')->slug = Str::slug($arabicName);

            $product->translateOrNew('en')->name = $englishName;
            $product->translateOrNew('en')->slug = Str::slug($englishName);

            $product->save();

            $importedCount++;
        }

        fclose($handle);
        Storage::delete($path); // Delete the temp file

        return response()->json([
            'message' => "Imported {$importedCount} products successfully.",
        ]);
    }




}
