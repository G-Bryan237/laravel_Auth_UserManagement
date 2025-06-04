<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'school_classes'; // Change from 'Class' to 'school_classes'
    protected $primaryKey = 'ClassID';
    public $timestamps = false;
    
    protected $fillable = [
        'ClassName',
        'SchoolID'
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'SchoolID', 'SchoolID');
    }

    public function specialities()
    {
        return $this->hasMany(Speciality::class, 'ClassID', 'ClassID');
    }
}
