<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UsersRequest;
use Illuminate\Http\Request;
use App\Services\ImagesService;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index (UsersRequest $request) 
    {   

        try {

            $count = $request->count ?? 6;
        
            $pagination = UserResource::collection(User::all()->sortBy("id"))->paginate($count);

            if ($pagination->isNotEmpty()) {

                $response = Array (
                    'success'       => true,
                    'page'          => $pagination->currentPage(),
                    "total_pages"   => ceil($pagination->total()/$pagination->perPage()),
                    "total_users"   => $pagination->total(),
                    "count"         => $pagination->perPage(),
                    "links"         => [
                        "next_url" => $pagination->nextPageUrl(),
                        "prev_url" => $pagination->previousPageUrl()
                    ],
                    'users' => $pagination->items()
                );
        
                return response()->json($response, 200);

            }

            return response()->json(Array(
                'success' => false,
                'message' => 'Users not found'
            ), 422);
          
        } catch (\Exception $e) {
        
            return response()->json(Array(
                'success'   => false,
                'message'   => $e->getMessage()
            ), 500);

        }

    }

    public function show(Request $request)
    {
        try {

            $user =  new UserResource(User::findOrFail($request->route('id')));
            
            return response()->json( ['success' => true, 'user' => $user], 200);

        } catch (\Exception $e) {
        
            return response()->json(Array(
                'success'   => false,
                'message'   => $e->getMessage()
            ), 500);

        }

    }

    public function store (UserStoreRequest $request, ImagesService $service) 
    {

        $data = Array (
            "name"        => $request->name,
            "email"       => $request->email,
            "phone"       => $request->phone,
            "position_id" => $request->position_id,
            "photo"       => $service->store($request->photo),
            'password'    => Hash::make('test')
        );

        try {

            $user = User::create($data);
            $user->positions()->sync($request->position_id);

            return response()->json(Array(
                'success'   => true,
                'user_id'   => $user->id,
                'message'   => "New user successfully registered"
            ), 200);

        } catch (\Exception $e) {
     
            return response()->json(Array(
                'success'   => false,
                'message'   => $e->getMessage()
            ), 500);

        }

    }

}
