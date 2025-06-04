<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends Model
{
    use HasFactory;

    protected $primaryKey = 'RegionID';
    public $timestamps = false;

    protected $fillable = [
        'RegionName', 
        'CountryCode'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'CountryCode', 'CountryCode');
    }

    public function schools()
    {
        return $this->hasMany(School::class, 'RegionID', 'RegionID');
    }
}
