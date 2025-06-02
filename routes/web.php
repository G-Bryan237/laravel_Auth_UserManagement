<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/db-check', function () {
    try {
        DB::connection()->getPdo();
        return "Connected successfully to DB!";
    } catch (\Exception $e) {
        return "Database connection error: " . $e->getMessage();
    }
});
Route::get('/', function () {
    return view('welcome');
});