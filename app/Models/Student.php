<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'student_info';
    
    protected $fillable = [
        'name',
        'roll',
        'class',
        'city',
        'pcontact',
        'photo'
    ];
    
    protected $casts = [
        'roll' => 'integer',
    ];
}
