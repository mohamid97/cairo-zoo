<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discounts extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'target_id', 'percentage' , 'discount_amount','discount_percentage'];


    public function product()
    {
        return $this->belongsTo(Product::class, 'target_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'target_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'target_id');
    }




}
