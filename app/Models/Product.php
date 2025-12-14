<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Store;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\TransactionDetail;
use App\Models\ProductReview;

class Product extends Model
{
    use HasFactory;

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

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function thumbnail()
    {
        return $this->hasOne(ProductImage::class)->where('is_thumbnail', 1);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function getThumbnailUrlAttribute()
    {
        $thumbnail = $this->images()->where('is_thumbnail', true)->first();
        if ($thumbnail && Str::startsWith($thumbnail->image, 'storage/')) {
            return asset($thumbnail->image);
        }
        return asset('images/default-product.png');
    }
}
