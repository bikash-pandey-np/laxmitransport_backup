<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Quote;

class QuoteItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'quantity',
        'weight',
        'length',
        'width',
        'height',
        'quote_id',
        'is_stackable',
        'is_hazardous',
    ];
    
    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}
