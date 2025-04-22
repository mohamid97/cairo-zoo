<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class UserAddress extends Model 
{
    use HasFactory;
    protected $fillable = ['gov_id' , 'city_id' , 'user_id' , 'address'];

}
