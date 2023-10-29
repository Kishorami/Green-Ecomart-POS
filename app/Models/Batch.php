<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_code ', 'note', 'import_date', 'supplier_id', 'supply_price', 'paid_amount', 'due_amount',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }


    public function scopeSearch($query,$term)
    {
        $term = "%$term%";
        $query->where(function($query) use ($term)
        {
            $query->where('batch_code','like',$term)
                    ->orWhere('note','like',$term)
                    ->orWhere('import_date','like',$term)
                    ->orWhereHas('supplier', function($query) use ($term){
                        $query->where('name','like',$term);
                    });
        });
    }
}
