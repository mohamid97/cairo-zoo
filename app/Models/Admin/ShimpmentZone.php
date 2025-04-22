<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShimpmentZone extends Model
{
    use HasFactory , HasFactory , Translatable , SoftDeletes;
    protected $fillable = ['price'];
    public $translatedAttributes = ['name', 'details'];
    public $translationForeignKey = 'shimpment_zone_id';
    public $translationModel = 'App\Models\Admin\ShimpmentZoneTranslation';
}
