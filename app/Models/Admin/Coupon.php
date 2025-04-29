<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = ['code','type','discount_value','start_date' , 'end_date' , 'times_used' , 'usage_limit' , 'is_active'];


    public function isValidForProduct($product)
    {
        if (!$this->is_active) return false;

        if ($this->start_date && now()->lt($this->start_date)) return false;
        if ($this->end_date && now()->gt($this->end_date)) return false;

        if ($this->usage_limit && $this->times_used >= $this->usage_limit) return false;

        return true;

    }





}
