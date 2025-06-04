<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'CategoryID';
    public $timestamps = false;

    protected $fillable = [
        'CategoryName', 
        'CountryCode'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'CountryCode', 'CountryCode');
    }

    public function schools()
    {
        return $this->hasMany(School::class, 'CategoryID', 'CategoryID');
    }
}
