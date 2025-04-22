<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurteamTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'name' , 'des'];
}
