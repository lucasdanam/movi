<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TransportistaParametros;
use GuzzleHttp\Client;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use const App\Models\TIPOS;

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
            if ($user->tipo == TIPOS['TRANSPORTISTA']) {
                $userParametros = new TransportistaParametros();
                $userParametros->cantidad = $request->cantidad;
                $userParametros->peso = $request->peso;
                $userParametros->user_id = $user->id;
                $userParametros->save();
            }
            return json_encode("The user ". $request->email ." was saved");
        } catch ( \Exception $e) {
            return json_encode("Error: " . $e->getMessage());
        }
    }

    public function login(Request $request): bool|string
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($request->email)->plainTextToken;
    }

    public function getTransportistas(Request $request) {
        $endpoint = "https://kpdcl1lx-8500.brs.devtunnels.ms/transportistas";
        $client = new Client();

        $response = $client->request('GET', $endpoint);
        $statusCode = $response->getStatusCode();
        $content = $response->getBody();
        $transportistasActivosIds = [12];
        try {
            $users = User::join('transportista_parametros', 'users.id', '=', 'transportista_parametros.user_id')
                ->where('peso', $request->peso)
                ->where('cantidad', request()->cantidad)
                ->whereIn('users.id', $transportistasActivosIds)
                ->get();
            return json_encode($users);
        } catch ( \Exception $e) {
            return json_encode("Error: " . $e->getMessage());
        }
    }

   /* public function elegirTransportista(Request $request) {
        var_dump($request->getUser());die();
    }*/
}