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
    public $translatedAttributes = ['des', 'name' , 'meta_des' , 'meta_title' , 'slug'];
    protected $fillable = ['category_id' , 'sku' , 'price' , 'star' , 'old_price' , 'discount' , 'video'];
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


}
