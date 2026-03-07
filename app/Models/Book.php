<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'inventory_count'
    ];

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function borrowItems()
    {
        return $this->hasMany(BorrowItem::class);
    }
}