<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'school_classes';
    protected $primaryKey = 'id'; // Use 'id' instead of 'ClassID'
    public $timestamps = true; // Enable timestamps since table has created_at/updated_at
    
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
        return $this->hasMany(Speciality::class, 'ClassID', 'id'); // Use 'id' as foreign key
    }
}
