<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create(Request $request): bool|string
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->tipo = $request->tipo;
            $user->save();
            return json_encode("The user ". $request->email ." was saved");
        } catch ( \Exception $e) {
            return json_encode("Error: " . $e->getMessage());
        }
    }
}