<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $primaryKey = 'CountryCode';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'CountryCode',
        'CountryName'
    ];

    public function regions()
    {
        return $this->hasMany(Region::class, 'CountryID', 'CountryCode');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'CountryID', 'CountryCode');
    }
}

