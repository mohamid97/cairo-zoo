<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    use HasFactory;
    protected $fillable = ['order_id' , 'gov_id' , 'city_id' , 'address'];
    public function gov(){
        return $this->belongsTo(Govs::class , 'gov_id');

    }
    public function city(){
        return $this->belongsTo(City::class , 'city_id');
    }
}
