<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\Request;

class DefaultController extends Controller
{
    public function default()
    {
        return view('welcome', [
            'test' => Request::ip()
        ]);
    }
}
