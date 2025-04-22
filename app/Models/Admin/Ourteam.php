<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Ourteam extends Model implements TranslatableContract
{
    use HasFactory ,Translatable, SoftDeletes;
    public $translatedAttributes = ['title', 'name' , 'des'];
    protected $fillable = ['facebook' , 'instagram' , 'linkedin' , 'twitter','tiktok' , 'youtube' , 'image'];
    public $translationForeignKey = 'ourteam_id';
    public $translationModel = 'App\Models\Admin\OurteamTranslation';
}
