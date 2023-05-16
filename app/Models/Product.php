<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model implements TranslatableContract
{
    use HasFactory, Translatable, SoftDeletes;

    public $translatedAttributes = ["name", "desc"];
    protected $fillable = ["category_id", "purchase_price", "sell_price", "stock", "image"];
    protected $appends = ["profit_percent"];

    public function getProfitPercentAttribute()
    {
        $profit = $this->sell_price - $this->purchase_price;
        $profit_percent = $profit * 100 / $this->purchase_price;
        return $profit_percent;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, "product_order");
    }
}
