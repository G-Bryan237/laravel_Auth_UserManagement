<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Specialty extends Model
{
    use HasFactory;

    protected $primaryKey = 'SpecialtyID';
    public $timestamps = false; // Using CreatedAt only
    
    protected $fillable = [
        'SpecialtyName',
        'Description', 
        'SchoolID',
        'ClassID'
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'SchoolID', 'SchoolID');
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'ClassID', 'id');
    }
}
