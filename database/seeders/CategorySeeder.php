<?php
namespace Database\Seeders;



use Illuminate\Database\Seeder;
use App\Models\Admin\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['en' => 'Electronics', 'ar' => 'إلكترونيات'],
            ['en' => 'Clothing', 'ar' => 'ملابس'],
            ['en' => 'Books', 'ar' => 'كتب'],
        ];

        foreach ($categories as $index => $catData) {
            $category = Category::create([
                'type' => '0',
                'parent_id' => null,
                'star' => null,
                'photo' => 'categories/photo_' . $index . '.jpg',
                'thumbinal' => 'categories/thumb_' . $index . '.jpg'
            ]);

            foreach (['en', 'ar'] as $locale) {
                $category->translateOrNew($locale)->name = $catData[$locale];
                $category->translateOrNew($locale)->slug = strtolower($catData['en']);
                $category->translateOrNew($locale)->des = 'Category description ' . $catData[$locale];
                $category->translateOrNew($locale)->small_des = 'Short ' . $catData[$locale];
                $category->translateOrNew($locale)->meta_des = 'Meta ' . $catData[$locale];
                $category->translateOrNew($locale)->meta_title = 'Title ' . $catData[$locale];
                $category->translateOrNew($locale)->alt_image = 'Alt ' . $catData[$locale];
                $category->translateOrNew($locale)->title_image = 'Title image ' . $catData[$locale];
            }

            $category->save();
        }
    }
}
