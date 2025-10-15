<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    /** @use HasFactory<\Database\Factories\DistributionFactory> */
    use HasFactory;

    protected $fillable = ['barista_id', 'total_qty', 'estimated_result', 'notes', 'created_by'];


    public function barista()
    {
        return $this->belongsTo(User::class, 'barista_id');
    }


    public function details()
    {
        return $this->hasMany(DistributionDetail::class);
    }
}
