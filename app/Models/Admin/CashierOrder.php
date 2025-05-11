<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\CashierOrderDetail;

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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function items(){
        return $this->hasMany(CashierOrderDetail::class  , 'order_id');
    }

}
