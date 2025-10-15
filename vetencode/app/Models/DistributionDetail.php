<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionDetail extends Model
{
    /** @use HasFactory<\Database\Factories\DistributionDetailFactory> */
    use HasFactory;

    protected $fillable = ['distribution_id', 'product_id', 'qty', 'price', 'total', 'created_by'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function distribution()
    {
        return $this->belongsTo(Distribution::class);
    }
}
