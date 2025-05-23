<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class ProductProp extends Model implements  TranslatableContract
{
    use HasFactory , Translatable;
    protected $fillable = ['status' , 'product_id'];
    public $translatedAttributes = ['name' ,'value'];
    public $translationForeignKey = 'prop_id';
    public $translationModel = 'App\Models\Admin\ProductPropTranslation';


}
