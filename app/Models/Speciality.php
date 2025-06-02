<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Speciality extends Model
{
    use HasFactory;

    protected $table = 'Speciality';
    protected $primaryKey = 'SpecialityID';
    
    protected $fillable = [
        'SchoolID',
        'ClassID',
        'SpecialityName'
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'SchoolID');
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'ClassID');
    }
}
