<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\Brand;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $brands = ['Nike', 'Adidas', 'Puma', 'Reebok', 'Under Armour'];

        foreach ($brands as $name) {
            $brand = Brand::create([
                'status' => '1',
                'image' => 'brands/' . strtolower($name) . '.png'
            ]);

            foreach (['en', 'ar'] as $locale) {
                $brand->translateOrNew($locale)->name = $locale === 'en' ? $name : 'براند ' . $name;
                $brand->translateOrNew($locale)->slug = strtolower($name);
                $brand->translateOrNew($locale)->des = $locale === 'en' ? 'Description for ' . $name : 'وصف ' . $name;
            }

            $brand->save();
        }
    }
}
