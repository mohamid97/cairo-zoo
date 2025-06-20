<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'points',
        'pounds',
        'order_id',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
