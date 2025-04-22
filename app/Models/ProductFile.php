<?php

namespace App\Models;

use App\Models\Admin\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFile extends Model
{
    use HasFactory;
    protected $fillable = ['name' , 'file'];

    public  function  product(){
        return $this->belongsTo(Product::class , 'product_id');
    }
}
