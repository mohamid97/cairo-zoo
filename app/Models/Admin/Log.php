<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;


    protected $fillable = ['user_id', 'action', 'model_type', 'model_id', 'changes'];



    protected $casts = [
        'changes' => 'array',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }




}
