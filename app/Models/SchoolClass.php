<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'Class';
    protected $primaryKey = 'ClassID';
    
    protected $fillable = [
        'ClassName',
        'SchoolID'
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'SchoolID');
    }

    public function specialities()
    {
        return $this->hasMany(Speciality::class, 'ClassID');
    }
}
