<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryItem extends Model
{
    use HasFactory;

    protected $table = 'cetegory_item';

    protected $fillable=
    [
        'item_id',
        'category-id'
    ];
}
