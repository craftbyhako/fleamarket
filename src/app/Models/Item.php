<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Sold;
use App\Models\User;
use App\Models\Like;


class Item extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'user_id',
        'condition_id',
        'item_name',
        'image',
        'brand',
        'price',
        'description',
    ];

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_item','item_id', 'category_id');
    }

    public function checkCategory($category, $item)
    {
         $category_id = $category->id;
         $item_id = $item->id;

         $item_data = Item::find($item_id);
         $categoriesItem = $item_data->categories;

         foreach ($categoriesItem as $categoryitem)
         {
            if($categoryItem->id == $category_id)
            {
                $returnTxt = "yes";
                return $returnTxt;
            }
         }

         if ($categoryItem->id != $category_id)
         {
            $returnTxt = "no";
            return $returnTxt;
         }
    }

    // Soldモデルとリレーション
    public function sold()
    {
        return $this->hasOne(Sold::class);

    }

    // 購入済みか判定する
    public function getIsSoldAttribute()
    {
    return $this->sold()->exists();
    }

    // Userモデルとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Likeモデルとのリレーション
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public  function likedUsers()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();;
    } 

    // Commentsモデルとのリレーション
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentedUsers()
    {
        return $this->belongsToMany(User::class, 'comments');
    }

}
