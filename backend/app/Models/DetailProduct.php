<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailProduct extends Model
{
    use HasFactory;
    protected $table ="details_product";
    protected $fillable = [
        'statusenabled', 'product_id', 'color_id', 'size_id', 'qty_product'
    ];

    public function product() : BelongsTo {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}
