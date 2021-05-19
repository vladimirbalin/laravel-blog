<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Blog\BaseController as GuestBaseController;
use App\Http\Middleware\AdminAuthenticate;

class BaseController extends GuestBaseController
{
    public function __construct()
    {
        $this->middleware(AdminAuthenticate::class);
    }
}
