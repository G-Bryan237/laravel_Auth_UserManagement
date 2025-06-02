<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'Admin';  // Change to capital A to match your migration
    protected $primaryKey = 'AdminID';
    public $timestamps = false;  // Disable timestamps

    protected $fillable = [
        'FullName',
        'Email',
        'PhoneNumber',
        'Whatsapp',
        'AcademicRecord',
        'Language',
        'Gender',
        'MaritalStatus',
        'Location',
        'WorkExperience',
        'Password'
    ];

    protected $hidden = [
        'Password'
    ];
}
