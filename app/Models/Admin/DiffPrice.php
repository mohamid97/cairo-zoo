<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiffPrice extends Model
{
    use HasFactory;
    protected $fillable = ['product_id' , 'amount','quantity' , 'date' , 'diff_amount'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
