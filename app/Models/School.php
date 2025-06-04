<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
    use HasFactory;

    protected $primaryKey = 'SchoolID';
    public $timestamps = false; // Using CreatedAt only
    
    protected $fillable = [
        'SchoolName',
        'SchoolCounty',
        'RegionID',
        'CategoryID',
        'Location',
        'ManagerID'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'RegionID', 'RegionID');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'CategoryID', 'CategoryID');
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class, 'ManagerID', 'id');
    }

    public function classes()
    {
        return $this->hasMany(SchoolClass::class, 'SchoolID', 'SchoolID');
    }

    public function specialities()
    {
        return $this->hasMany(Speciality::class, 'SchoolID', 'SchoolID');
    }
}
