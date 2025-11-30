<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sold;

class Message extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'sold_id',
        'user_id',
        'message',
        'image',
    ];

    public function sold()
    {
        return $this->belongsTo(Sold::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
