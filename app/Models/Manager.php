<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Manager extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email', 
        'phone',
        'date_of_birth',
        'language',
        'gender',
        'marital_status',
        'location',
        'role',
        'password',
        'working_experience'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'date_of_birth' => 'date'
    ];  
    
}