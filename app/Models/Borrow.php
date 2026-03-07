<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    public function student()
{
    return $this->belongsTo(Student::class);
}

public function items()
{
    return $this->hasMany(BorrowItem::class);
}
}
