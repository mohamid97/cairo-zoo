<?php

namespace Database\Seeders;

use App\Models\Admin\Brand;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::all();
        $brands = Brand::all();

        for ($i = 1; $i <= 30; $i++) {
            $category = $categories->random();
            $brand = $brands->random();

            $product = Product::create([
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'barcode' => 'BAR' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'status' => 'published',
                'image' => 'products/image_' . $i . '.jpg',
                'thumbinal' => 'products/thumb_' . $i . '.jpg',
                'stock' => rand(10, 100),
                'sku' => 'SKU' . $i,
                'sales_price' => rand(50, 500),
                'star' => rand(1, 5),
                'weight' => rand(1, 10),
                'height' => rand(10, 100),
                'length' => rand(10, 100),
                'width' => rand(10, 100),
                'video' => 'https://example.com/video.mp4'
            ]);

            foreach (['en', 'ar'] as $locale) {
                $product->translateOrNew($locale)->name = $locale === 'en' ? 'Product ' . $i : 'منتج ' . $i;
                $product->translateOrNew($locale)->slug = 'product-' . $i;
                $product->translateOrNew($locale)->des = 'Detailed description of product ' . $i;
                $product->translateOrNew($locale)->small_des = 'Short description ' . $i;
                $product->translateOrNew($locale)->meta_des = 'Meta description ' . $i;
                $product->translateOrNew($locale)->meta_title = 'Meta title ' . $i;
                $product->translateOrNew($locale)->taste = 'taste' . $locale;
            }

            $product->save();
        }
    }
}
