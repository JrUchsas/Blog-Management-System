<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['category_id', 'title', 'slug', 'details', 'image', 'status'];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }
}
