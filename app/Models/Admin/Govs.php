<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Govs extends Model implements  TranslatableContract
{
    use HasFactory , Translatable;

    protected $fillable = ['code' , 'checked'];
    public $translatedAttributes = ['des', 'small_des' , 'name'];
    public $translationForeignKey = 'gov_id';
    public $translationModel = 'App\Models\Admin\GovsTranslation';



    public function cities(){
        return $this->hasMany(City::class , 'gov_id');
    }
}
