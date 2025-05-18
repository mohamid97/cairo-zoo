<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;


class Taste extends Model implements  TranslatableContract
{

    use HasFactory , Translatable;
    protected $fillable = ['image'];
    public $translatedAttributes = [ 'name' , 'slug' , 'des'];
    public $translationForeignKey = 'taste_id';
    public $translationModel = 'App\Models\Admin\TasteTranslation';
}
