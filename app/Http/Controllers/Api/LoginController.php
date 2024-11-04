<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Http\Requests\BlockRequest;
use Illuminate\Http\Response;
use App\Http\Resources\UserResource;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // if(!Auth::attemp($request->only('email', 'password'))) {

        // }
        // return new User
    }
}
