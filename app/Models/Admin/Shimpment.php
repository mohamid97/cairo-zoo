<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shimpment extends Model
{
    use HasFactory;

    protected $fillable = ['is_free' , 'details'];
}
