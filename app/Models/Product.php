<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    //fillable - ALLOW
    protected $fillable = [
        'name',
        'image',
        'price',
        'qty',
        'description',
        'status',
        'product_category_id',
        'slug'
    ];

    //guarded - NOT ALLOW
    // protected $guarded = [];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}
