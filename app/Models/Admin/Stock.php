<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = ['quantity' , 'product_id' , 'cost_price' , 'sales_price'];
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
