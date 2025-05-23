<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class Ourwork extends Model implements TranslatableContract
{
    use HasFactory , Translatable , SoftDeletes;

    protected $fillable = ['icon' , 'photo' , 'link'];
    public $translatedAttributes = ['des', 'name' ,'alt_image' , 'title_image' , 'meta_title' , 'meta_des'];
    public $translationForeignKey = 'ourwork_id';
    public $translationModel = 'App\Models\Admin\OurworkTranslation';


    public function gallery(){
        return $this->hasMany(OurworkGallery::class , 'our_work_id');
    }




}
