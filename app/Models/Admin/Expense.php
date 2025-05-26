<?php

namespace App\Models\Admin;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = ['name' , 'type'];

    public function expense(){
        return $this->hasMany(ExpenseAmount::class);
    }

    public function latestAmount()
    {
        return $this->hasOne(ExpenseAmount::class)->latestOfMany();
    }



    public function latestAmountCurrentMonth()
    {
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        return $this->hasOne(ExpenseAmount::class)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->latest('date'); // get the latest record in the current month
    }

    public function expenseAmounts()
    {
        return $this->hasMany(ExpenseAmount::class);
    }

   






}
