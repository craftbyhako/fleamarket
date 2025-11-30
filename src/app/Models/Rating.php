<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'target_user_id',
        'rater_id',
        'score'
    ];

    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    public function rater()
    {
        return $this->belongsTo(User::class, 'rater_id');
    }
}
