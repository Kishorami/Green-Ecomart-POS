<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchedItem extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'batch_id', 'category_id', 'item_description', 'sku', 'unit_id', 'quantity', 'stock', 'unit_price', 'sell_price',
    ];


    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }


    public function scopeSearch($query,$term)
    {
        $term = "%$term%";
        $query->where(function($query) use ($term)
        {
            $query->where('item_description','like',$term)
                    ->orWhere('sku','like',$term);
        });
    }
}
