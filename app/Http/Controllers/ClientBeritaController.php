<?php

namespace App\Http\Controllers;

use App\Berita;
use Illuminate\Http\Request;

class ClientBeritaController extends Controller
{
    public function index() 
    {
        $beritas = Berita::orderBy('id', 'desc')->paginate(5);
        
        return view('pages.berita', ['beritas' => $beritas]);
    }
}
