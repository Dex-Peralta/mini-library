<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowItem extends Model
{
    public function borrow()
{
    return $this->belongsTo(Borrow::class);
}

public function book()
{
    return $this->belongsTo(Book::class);
}
}
