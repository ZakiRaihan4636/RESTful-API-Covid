<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    # membuat function register
    public function register(Request $request)
    {
        /**
         * alur register:
         * 1. menerima data dari user
         * 2. memasukkan data ke database
         */

        # memvalidasi request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        # mengambil request
        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        # menambah data pada tabel user
        $user = User::create($input);

        if ($user) {
            $data = [
                'message' => 'User is created successfully!',
            ];

            # mengembalikan data user dan code 201
            return response()->json($data, 201);
        } else {
            $data = [
                'message' => 'User is created successfully'
            ];

            return response()->json($data);
        }
    }

    # membuat function login
    public function login(Request $request)
    {
        $input = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        # mencari user berdasarkan email
        $user = User::where('email', $input['email'])->first();

        # membuat token
        $token = $user->createToken('auth_token');

        # membuat logika login dengan membandingkan data inputan dengan data dari database
        $isLogin = $input['email'] == $user->email && Hash::check($input['password'], $user->password);

        if ($isLogin) {
            $data = [
                'message' => 'Login successfully',
                'token' => $token->plainTextToken
            ];

            # mengembalikan token dan code 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Email or password wrong'
            ];

            # mengembalikan kode json 401 dengan pesan login gagal
            return response()->json($data, 401);
        }
    }
}
