<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;


class Partener extends Model implements  TranslatableContract
{
    use HasFactory , Translatable , SoftDeletes;

    protected $fillable = ['icon'];
    public $translatedAttributes = ['address', 'name'];
    public $translationForeignKey = 'partener_id';
    public $translationModel = 'App\Models\Admin\PartenerTranslation';


}
