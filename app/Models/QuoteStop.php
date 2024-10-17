<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Quote;
use App\Models\QuoteStopItem;

class QuoteStop extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination',
        'instructions',
        'quote_id',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function items()
    {
        return $this->hasMany(QuoteStopItem::class);
    }
}
