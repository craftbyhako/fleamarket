<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Like;
use App\Models\Message;
use App\Models\Rating;
use Illuminate\Database\Eloquent\Relations\HasMany;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name',
        'email',
        'password',
        'image',
        'postcode',
        'address',
        'building',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',

    ];

    // Likeモデルとのリレーション
    public function likes()
    {
        return $this->hasMany(Like::class); 
    }

    public function likedItems() 
    {
        return $this->belongsToMany(Item::class, 'likes', 'user_id', 'item_id')->withTimestamps();
    }
    
    // Commentsモデルとのリレーション
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentedItems()
    {
        return $this->belongsToMany(Item::class, 'comments');
    }

    // itemsとのリレーション
    public function items(): HasMany
    {
         return $this->hasMany(Item::class);
    }

    public function boughtItems()
    {
        return $this->hasManyThrough(
            Item::class,
            Sold::class,
            'user_id',
            'id',
            'id',
            'item_id',
        );
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function receivedRatings()
    {
        return $this->hasMany(Rating::class, 'target_user_id');
    }

    public function getRoundedAverageRatingAttribute()
    {
        $avg = $this->receivedRatings()->avg('score');

        return $avg ? round($avg) : null; 
    }

    public function getRatingsCountAttribute()
    {
        return $this->receivedRatings()->count();
    }

    public function givenRatings()
    {
        return $this->hasMany(Rating::class, 'rater_id');
    }
    
}

