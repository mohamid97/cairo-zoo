<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class City extends Model implements  TranslatableContract
{
    use HasFactory , Translatable;

    protected $fillable = ['code' , 'checked' , 'gov_id'];
    public $translatedAttributes = ['des', 'small_des' , 'name'];
    public $translationForeignKey = 'city_id';
    public $translationModel = 'App\Models\Admin\CityTranslation';

    public function zone(){
        return $this->belongsTo(ShimpmentZone::class , 'zone_id');
    }
}
