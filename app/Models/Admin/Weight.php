<?php

namespace App\Models\Admin;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weight extends Model implements  TranslatableContract
{
    use HasFactory , Translatable;
    protected $fillable = ['status'];
    public $translatedAttributes = [ 'name'];
    public $translationForeignKey = 'weight_id';
    public $translationModel = 'App\Models\Admin\WeightTranslation';
}
