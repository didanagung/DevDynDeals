<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Products extends Model
{
    // use HasFactory;
    // use HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'statusenabled', 'name', 'qty_product', 'short_description', 'description'
    ];

    // membuat uuid secara otomatis
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function detailProducts() : HasMany
    {
        return $this->hasMany(DetailProduct::class, 'product_id', 'id');
    }
}
