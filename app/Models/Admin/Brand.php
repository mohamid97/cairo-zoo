<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Brand extends Model implements  TranslatableContract
{
    use HasFactory , Translatable;
    protected $fillable = ['status' , 'image'];
    public $translatedAttributes = [ 'name' , 'slug' , 'des'];
    public $translationForeignKey = 'brand_id';
    public $translationModel = 'App\Models\Admin\BrandTranslation';
}
