<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $table = 'Country'; // Match your migration table name
    protected $primaryKey = 'CountryCode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false; // Your migration doesn't have updated_at
    
    protected $fillable = [
        'CountryCode',
        'CountryName'
    ];

    public function regions()
    {
        return $this->hasMany(Region::class, 'CountryCode', 'CountryCode');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'CountryCode', 'CountryCode');
    }
}

