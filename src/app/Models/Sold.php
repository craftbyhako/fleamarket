<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class Sold extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'user_id',
        'item_id',
        'payment',
        'destination_postcode',
        'destination_address',
        'destination_building'
    ];

    // Itemモデルとリレーション
    public function item()
    {
    return $this->belongsTo(Item::class);
    }

}
