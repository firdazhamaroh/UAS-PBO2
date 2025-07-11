<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'product_category_id',
        'thumbnail',
        'product_name',
        'description',
        'price',
        'stock',
        'status',
    ];
    

    public function product_category()
    {
        return $this->belongsto(ProductCategory::class, 'product_category_id');
    }

    public function discount()
    {
        return $this->hasOne(Discount::class);
    }


}
