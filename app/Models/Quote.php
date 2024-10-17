<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shipper;
use Illuminate\Support\Str;
use App\Models\QuoteItem;
use App\Models\QuoteStop;
class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'load_type',
        'identifier',
        'origin',
        'destination',
        'pickup_date',
        'instructions',
        'status',
        'shipper_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($quote) {
            $quote->identifier = static::generateUniqueIdentifier();
        });
    }


    public function items()
    {
        return $this->hasMany(QuoteItem::class);
    }

    public function stops()
    {
        return $this->hasMany(QuoteStop::class);
    }

    public function shipper()
    {
        return $this->belongsTo(Shipper::class);
    }

    protected static function generateUniqueIdentifier()
    {
        do {
            $identifier = strtoupper(Str::random(10));
        } while (self::where('identifier', $identifier)->exists());

        return $identifier;
    }
}
