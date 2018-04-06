<?php

namespace App\Http\Controllers;
use App\User;
use App\Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //

    public function createUser(Request $request) {
        $message = 'User created';
        $userRequest = $request->get('data');
        $params = json_decode($userRequest);
        $username = (isset($params->username)) ? $params->username : null;
        $email = (isset($params->email)) ? $params->email : null;
        $password = Hash::make((isset($params->password)) ? $params->password : null);
        $valid = true;

         if( !empty($email) && !empty($password) && !empty($username)) {
             $valid = false;
             $exist_email = User::where('email', $email)->get();
             $exist_username = User::where('username', $username)->get();
             if(count($exist_email) > 0 || count($exist_username) > 0 ) {
                 $message = 'email or username already exists';

             } else {
                 User::create([
                     'username' => $username,
                     'email' => $email,
                     'password' => $password
                 ]);

                 $valid = true;
                 $message = 'User created succesfully';
             }
         }

         if(empty($email) && empty($password) && empty($username) ){
             $message= 'username, mail o password vacios';
         }
         $content = ['message' => $message, 'valid' => $valid ];
         $status = 200;
         $type = 'aplication/json';

         return response($content, $status)
         ->withHeaders([
            'Content-Type' => $type,
            'X-Header-One' => 'Header Value',
            'X-Header-Two' => 'Header Value',
        ]);

    }
}
