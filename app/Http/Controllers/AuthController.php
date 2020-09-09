<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    public function register(Request $request){
        
        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->save();

        $http = new Client;

        $response = $http->post(url('oauth/token'), [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => 'client-id',
                'client_secret' => 'client-secret',
                'username'=>$request->email,
                'password'=>$request->password,
              //  'redirect_uri' => 'http://example.com/callback',
                'scope' =>'',
            ],
        ]);
    
        return json_decode((string) $response->getBody(), true);



    }
}
