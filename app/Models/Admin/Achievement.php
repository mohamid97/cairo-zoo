<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Achievement extends Model implements  TranslatableContract
{
    use HasFactory , Translatable;
    protected $fillable = ['icon' , 'number'];
    public $translatedAttributes = ['name', 'des'];
    public $translationForeignKey = 'achievement_id';
    public $translationModel = 'App\Models\Admin\AchievementTranslation';
}
