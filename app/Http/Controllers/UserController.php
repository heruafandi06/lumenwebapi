<?php

namespace App\Http\Controllers;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get_user($id)
    {
        $user = User::find($id);
        if($user){
            return response()->json([
              'success' => true,
              'message' => 'User ditemukan',
              'data' => $user
            ], 200);
        }else{
            return response()->json([
              'success' => false,
              'message' => 'User tidak ditemukan',
              'data' => ''
            ], 404);
        }
    }
}
