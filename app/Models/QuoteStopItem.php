<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\QuoteStop;
class QuoteStopItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'quantity',
        'weight',
        'length',
        'width',
        'height',
        'quote_stop_id',
        'is_stackable',
        'is_hazardous',
    ];

    public function quoteStop()
    {
        return $this->belongsTo(QuoteStop::class);
    }
}
