<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('holamon',function(){
    return 'Hola Mon!';
});

Route::get('holamon/{nom}',function($nom){
    return 'Hola Mon! '.$nom;
});