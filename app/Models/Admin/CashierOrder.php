<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\CashierOrderDetail;
use App\Models\User;

class CashierOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'coupon-code',
        'coupon_discount',
        'total_amount_before_discount',
        'total_amount_after_discount',
        'total_discount',
        'status',
        'message_retrieval'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function items(){
        return $this->hasMany(CashierOrderDetail::class  , 'order_id');
    }

    public function order_info(){
        return $this->hasMany(CahierOrderInfo::class , 'order_id');
    }

}
