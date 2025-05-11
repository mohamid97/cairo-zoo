<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashierOrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'price_before_discount',
        'price_after_discount',
        'total_price_before_discount',
        'total_price_after_discount',
        'discount',
        'quantity',
        'discount_type',
        'discount_percentage',
        'discount_amount'
   
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(CashierOrder::class, 'order_id');
    }
    

}
