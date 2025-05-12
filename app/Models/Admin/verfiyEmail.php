<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class verfiyEmail extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'code',
        'expires_at',
    ];
}
