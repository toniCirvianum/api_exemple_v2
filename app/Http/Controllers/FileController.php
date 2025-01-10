<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function getFile($filename)
    {
        $path = storage_path('app/public/' . $filename);
        if (!file_exists($path)) {
            abort(404);
        }
        return response()->file($path);
    }
}
