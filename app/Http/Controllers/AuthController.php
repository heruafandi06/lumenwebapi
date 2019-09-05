<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $nama = $request->nama;
        $email = $request->email;
        $password = Hash::make($request->password);

        $register = User::create([
          'nama' => $nama,
          'email' => $email,
          'password' => $password,
        ]);

        if($register){
          return response()->json([
            'success' => true,
            'message' => 'Pendaftaran sukses',
            'data' => $register
          ], 201);
        }else{
          return response()->json([
            'success' => false,
            'message' => 'Pendaftaran gagal',
            'data' => ''
          ], 400);
        }
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();
        if($user){
            if(Hash::check($password, $user->password)){
              $api_token = base64_encode(str_random(40));
              $user->update(['api_token' => $api_token]);

              return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'data' => [
                  'user' => $user,
                  'api_token' => $api_token
                ]
              ], 201);
            }else{
              return response()->json([
                'success' => false,
                'message' => 'Passwordnya salah',
                'data' => ''
              ], 400);
            }
        }else{
            return response()->json([
              'success' => false,
              'message' => 'Email tidak ditemukan',
              'data' => ''
            ], 400);
        }
    }
}
