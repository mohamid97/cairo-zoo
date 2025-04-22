<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagsTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['name' , 'meta_title' , 'meta_des' , 'slug'];

}
