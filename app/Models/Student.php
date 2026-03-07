<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'student_number',
        'course'
    ];

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }
}