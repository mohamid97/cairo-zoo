<?php

namespace App\Models\Admin;

use App\Http\Resources\Admin\CategoryResource;
use App\Models\Front\CardItem;
use App\Models\Front\Order;
use App\Models\ProductFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;

class Product extends Model implements TranslatableContract
{
    use HasFactory , Translatable , SoftDeletes;
    public $translatedAttributes = ['des', 'name' , 'small_des' , 'meta_des' , 'meta_title' , 'slug'];
    protected $fillable = ['category_id' , 'barcode' ,'brand_id' , 'status' , 'image' , 'stock' , 'thumbinal' , 'sku' , 'sales_price' , 'star' , 'weight' , 'height' , 'length' , 'width' , 'video'];
    public $translationForeignKey = 'product_id';
    public $translationModel = 'App\Models\Admin\ProductTranslation';

    public function gallery(){
        return $this->hasMany(Gallary::class , 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class , 'category_id');
    }

    public function cardItems()
    {
        return $this->hasMany(CardItem::class);
    }

    public  function files(){
        return $this->hasMany(ProductFile::class , 'product_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class);
    }

    // Define orders relationship
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items', 'product_id', 'order_id');
    }


    public function relatedProducts()
    {
        return $this->belongsToMany(Product::class, 'related_products', 'product_id', 'related_product_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class , 'brand_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function discounts()
    {
        return $this->hasOne(Discounts::class, 'target_id');
    }



    public function getBestDiscount()
    {
        // Global discount takes absolute priority
        $global = Discounts::where('type', 'global')->first();
        if ($global) {
            return $this->formatDiscount($global);
        }

        $discounts = [];

        // Product-specific discount
        $product = Discounts::where('type', 'product')
            ->where('target_id', $this->id)
            ->first();
        if ($product) {
            $discounts[] = $this->formatDiscount($product);
        }

        // Brand-specific discount
        $brand = Discounts::where('type', 'brand')
            ->where('target_id', $this->brand_id)
            ->first();
        if ($brand) {
            
            $discounts[] = $this->formatDiscount($brand);
        }

        // Nearest category-based discount
        $categoryDiscount = $this->getNearestCategoryDiscount();
        if ($categoryDiscount) {
            $discounts[] = $categoryDiscount;
        }

        // Return highest-value discount (amount or percentage)
        return collect($discounts)->sortByDesc('value')->first();
    }

    protected function formatDiscount($discount)
    {

        $salesPrice = $this->sales_price;

        if ($discount->percentage === 'YES') {
            $value = ($salesPrice * $discount->discount_percentage) / 100;
        } else {
            $value = $discount->discount_amount;
        }

       

        return [
            'type' => $discount->percentage === 'YES' ? 'percentage' : 'amount',
            'value' => ceil($value),
            'raw' => $discount, 
        ];


    }

    public function getNearestCategoryDiscount()
    {
        $category = $this->category;

        while ($category) {
            $discount = Discounts::where('type', 'category')
                ->where('target_id', $category->id)
                ->first();

            if ($discount) {
                return $this->formatDiscount($discount);
            }

            $category = $category->parent;
        }

        return null;
    }


    // wtite getPriceAfterDiscount function
    public function getPriceAfterDiscount()
    {
        $discount = $this->getBestDiscount();

        if ($discount) {
            if (isset($discount['value'])) {
                return $this->sales_price - $discount['value'];
            } 
        }

        return $this->sales_price;
    }













}
