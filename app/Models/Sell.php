<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    use HasFactory;

    protected $fillable = [
        'products', 'bill_no', 'customer_id', 'user_id', 'payment_method_id', 'net_price', 'paid', 'due', 'vat_percent', 'vat_amount', 'points_earned', 'points_used', 'points_discount', 'total_price', 'profit',
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->user_id = auth()->id();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function scopeSearch($query,$term)
    {
        $term = "%$term%";
        $query->where(function($query) use ($term)
        {
            $query->where('bill_no','like',$term)
                    ->orWhereHas('user', function($query) use ($term){
                        $query->where('name','like',$term);
                    })
                    ->orWhereHas('customer', function($query) use ($term){
                        $query->where('name','like',$term)
                                ->orWhere('code','like',$term);
                    });
        });
    }
}
