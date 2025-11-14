<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Auction extends Model {
    protected $fillable = ['seller_name','description','initial_price','scheduled_at'];

    protected $casts = [
        'initial_price' => 'decimal:2',
        'scheduled_at'  => 'datetime',
    ];

    public function bids(): HasMany {
        return $this->hasMany(Bid::class);
    }
}
