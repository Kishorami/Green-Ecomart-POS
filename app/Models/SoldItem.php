<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoldItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sell_id', 'batched_item_id', 'quantity', 'sell_price', 'profit', 'sold_from',
        ];

    public function product()
    {
        return $this->belongsTo(BatchedItem::class, 'batched_item_id')->with('unit');
    }
}
