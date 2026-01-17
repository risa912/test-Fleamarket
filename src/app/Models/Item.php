<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Condition;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'description',
        'price',
        'condition_id',
        'image',
        'user_id',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'item_categories', 'item_id', 'category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(ItemLike::class);
    }
    
    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }
}

