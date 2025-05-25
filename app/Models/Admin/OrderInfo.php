<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderInfo extends Model
{
    use HasFactory;
    protected $fillable = ['order_id' , 'product_id' , 'qty' , 'sales_price' , 'cost_price'];
}
