<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowItem extends Model
{
    protected $fillable = [
        'borrow_id',
        'book_id',
        'returned_at',
        'fine'
    ];

    protected $casts = [
        'returned_at' => 'datetime',
    ];

    public function borrow()
    {
        return $this->belongsTo(Borrow::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
