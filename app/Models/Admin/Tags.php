<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Tags extends Model implements  TranslatableContract
{
    use HasFactory , Translatable;
    protected $fillable = ['status'];
    public $translatedAttributes = [ 'name' , 'slug' , 'meta_title', 'meta_des'];
    public $translationForeignKey = 'tag_id';
    public $translationModel = 'App\Models\Admin\TagsTranslation';

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }


}
