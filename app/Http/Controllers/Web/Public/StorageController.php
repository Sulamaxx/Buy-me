<?php

namespace App\Http\Controllers\Web\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StorageController extends Controller
{
    public function getLogo($filename): StreamedResponse
    {
        $path = 'public/logo/' . $filename; 
        
        if (Storage::exists($path)) {
            return Storage::response($path);
        }

        abort(404);
    }
}
