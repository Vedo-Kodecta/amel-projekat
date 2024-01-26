<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
    }

    public function registerCustomer(RegisterRequest $request)
    {
        $user_role_id = $request->input('user_role_id', 1);

        dd($request);

        User::create(array_merge($request->validated(), ['user_role_id' => $user_role_id]));
    }

    public function registerAdmin(RegisterRequest $request)
    {
        $user_role_id = $request->input('user_role_id', 2);

        User::create(array_merge($request->validated(), ['user_role_id' => $user_role_id]));
    }
}
