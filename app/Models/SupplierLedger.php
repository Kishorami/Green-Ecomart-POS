<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierLedger extends Model
{
    use HasFactory;
    
    use HasFactory;

    protected   $fillable = [
                'supplier_id', 'date', 'particulars', 'batch_id', 'due_amount', 'payment_amount', 'total_due', 'payment_method_id', 'note',
                ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function scopeSearch($query,$term)
    {
        $term = "%$term%";
        $query->where(function($query) use ($term)
        {
            $query->where('particulars','like',$term);
        });
    }
}
