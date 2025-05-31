<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\Resource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function me()
    {
        return $this->successResponse(new Resource(Auth::user()));
    }
}
