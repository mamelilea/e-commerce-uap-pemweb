<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'store_id',
        'product_category_id',
        'name',
        'slug',
        'about',
        'condition',
        'price',
        'weight',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    /**
     * Get the thumbnail image URL for this product
     * Returns the thumbnail image if exists, otherwise the first image, or null
     */
    public function getThumbnailUrl()
    {
        $thumbnail = $this->productImages()->where('is_thumbnail', true)->first();
        if ($thumbnail) {
            return asset('storage/' . $thumbnail->image);
        }
        
        $firstImage = $this->productImages()->first();
        if ($firstImage) {
            return asset('storage/' . $firstImage->image);
        }
        
        return null;
    }
}
