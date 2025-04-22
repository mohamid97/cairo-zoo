<?php

namespace App\Models\Front;

use App\Models\Admin\OrderAddress;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id' , 'first_name' , 'last_name', 'phone' , 'total_price' , 'shipment_price' , 'payment_method' , 'payment_status' , 'status'];
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function address(){
        return $this->hasOne(OrderAddress::class , 'order_id');
    }
}
