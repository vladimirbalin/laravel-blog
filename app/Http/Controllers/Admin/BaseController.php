<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthenticate;

class BaseController extends Controller
{
    public function __construct()
    {
        $this->middleware(AdminAuthenticate::class);
    }
}
