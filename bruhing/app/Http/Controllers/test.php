<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class test extends Controller
{
    public function register(Request $req){
        $req->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users', ///johndoe@gmail.com in database error email is unique can not use the same
            'password'=>'required|string|confirmed' //'password':value , 'password_confirmation':value
        ]);
        User::create([
            'name'=>$req->name,
            'email'=>$req->email,
            'password'=>Hash::make($req->password) //john123 // hash john123 - > waajkwjalkdjalkw332312
        ]);

        return response()->json([
            'msg'=>'success' 
        ],201);
    }

    public function login(Request $req){
        $req->validate([
            'email'=>'required|email|string',
            'password'=>'required|string'
        ]);

        // Initialize an array to hold error messages
        $errors = [];

        // Retrieve user by email
        $user = User::where('email', $req->email)->first();

        // Check if the email exists
        if (!$user) {
            $errors['email'] = 'Email is not found! You need to register first.';
        } else {
            // Check if the password is correct, only if the email was found
            if (!Hash::check($req->password, $user->password)) {
                $errors['password'] = 'Password is incorrect.';
            }
        }

        // Prepare the response
        $response = [
            'data' => $req->all()
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }else{
            $ticket = $user->createToken('ticket');
            $response['ticket'] = $ticket;
        }

        
        // Return the response (adjust based on your application's needs)
        return response()->json($response,200);
    }
}
