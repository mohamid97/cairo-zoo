<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComparisonItem extends Model
{
    use HasFactory;

    protected $fillable = ['comparison_id', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    
}
