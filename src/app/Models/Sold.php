<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\Message;


class Sold extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'user_id',
        'item_id',
        'status',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Messageモデルとリレーション
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

}
