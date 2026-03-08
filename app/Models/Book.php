<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'inventory_count',
        'description',
        'year_published',
        'genre',
        'cover_image'
    ];

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function borrowItems()
    {
        return $this->hasMany(BorrowItem::class);
    }

    /**
     * Check if the book is available for checkout
     */
    public function isAvailable()
    {
        return $this->inventory_count > 0;
    }

    /**
     * Get the availability status
     */
    public function getStatus()
    {
        return $this->isAvailable() ? 'Available' : 'Out of Stock';
    }
}