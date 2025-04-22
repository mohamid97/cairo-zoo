<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShimpmentZoneTranslation extends Model
{
    use HasFactory;
    protected $fillable = [ 'name' , 'details'];
}
