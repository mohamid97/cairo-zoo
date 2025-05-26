<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseAmount extends Model
{
    use HasFactory;
    protected $fillable = ['amount' , 'date'];

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }
}
