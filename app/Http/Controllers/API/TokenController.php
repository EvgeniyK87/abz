<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    public function index () 
    {

        try {

            $api_token = Array ( 
                'token'      => hash('sha256', Str::random(60)),
                'expires_at' => Carbon::now()->addMinutes(40)
            );
    
            $token = Token::create($api_token);
            
            return response()->json( Array (
                'success'   => true,
                'token'     => $token->token
            ), 200);

        } catch (\Exception $e) {
        
            return response()->json(Array(
                'success'   => false,
                'message'   => $e->getMessage()
            ), 500);

        }

       
    }
}
