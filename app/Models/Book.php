<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'description',
        'isbn',
        'year_published',
        'genre',
        'publisher',
        'total_copies',
        'available_copies',
        'inventory_count', // Keep for backward compatibility
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
        return $this->available_copies > 0;
    }

    /**
     * Get the availability status
     */
    public function getStatus()
    {
        if ($this->available_copies > 0) {
            return 'Available (' . $this->available_copies . ' of ' . $this->total_copies . ')';
        }
        return 'Out of Stock';
    }

    /**
     * Decrease available copies (when borrowed)
     */
    public function decreaseAvailability($quantity = 1)
    {
        if ($this->available_copies >= $quantity) {
            $this->decrement('available_copies', $quantity);
            return true;
        }
        return false;
    }

    /**
     * Increase available copies (when returned)
     */
    public function increaseAvailability($quantity = 1)
    {
        if ($this->available_copies + $quantity <= $this->total_copies) {
            $this->increment('available_copies', $quantity);
            return true;
        }
        return false;
    }
}