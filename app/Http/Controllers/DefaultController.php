<?php


namespace App\Http\Controllers;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;

class DefaultController extends Controller
{
    public function default()
    {
        return view('welcome', [
            'test' => Carbon::tomorrow()->addHours(4)->addMinutes(35)
        ]);
    }

    public function second($id)
    {
        return view('welcome', [
            'test' => __METHOD__ . " $id"
        ]);
    }
}
