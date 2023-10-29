<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'contact', 'address', 'payment_info', 'note', 'user_id',
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

    public function scopeSearch($query,$term)
    {
        $term = "%$term%";
        $query->where(function($query) use ($term)
        {
            $query->where('name','like',$term)
                    ->orWhere('code','like',$term)
                    ->orWhere('contact','like',$term)
                    ->orWhereHas('user', function($query) use ($term){
                        $query->where('name','like',$term);
                    });
        });
    }
}
