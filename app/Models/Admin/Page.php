<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model implements  TranslatableContract
{
    use HasFactory , Translatable , SoftDeletes;
    protected $fillable = ['image'];
    public $translatedAttributes = ['des', 'name' , 'slug' , 'title_image' , 'alt_image' , 'meta_des' , 'meta_title'];
    public $translationForeignKey = 'page_id';
    public $translationModel = 'App\Models\Admin\PageTranslation';
}
