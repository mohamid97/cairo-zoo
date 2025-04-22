<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Event extends Model implements  TranslatableContract
{
    use HasFactory , Translatable;

    protected $fillable = ['date'];
    public $translatedAttributes = ['des', 'name'];
    public $translationForeignKey = 'event_id';
    public $translationModel = 'App\Models\Admin\EventTranslation';


    public function images(){
        return $this->hasMany(EventImage::class , 'event_id');
    }
}
