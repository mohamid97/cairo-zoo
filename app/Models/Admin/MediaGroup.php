<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Psy\CodeCleaner\FunctionContextPass;

class MediaGroup extends Model
{
    use HasFactory , SoftDeletes;


    public function gallerys(){
        return $this->hasMany(GalleryImage::class , 'media_group_id');
    }

    public function files(){
        return $this->hasMany(File::class , 'media_group_id');
    }

    public function viedos(){
        return $this->hasMany(Video::class , 'media_group_id');
    }






}
