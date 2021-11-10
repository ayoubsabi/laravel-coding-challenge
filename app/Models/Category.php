<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(self::class);
    }

    public function categories()
    {
        return $this->hasMany(self::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
