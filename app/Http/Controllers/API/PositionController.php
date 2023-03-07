<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Position;
use App\Http\Resources\PositionResource;


class PositionController extends Controller
{

    public function index () {

        try {

            $positions = PositionResource::collection(Position::all());

            if ($positions->isNotEmpty()) {
                return response()->json(Array(
                    'success' => true,
                    'positions' => $positions
                ), 200);
            }
            
            return response()->json(Array(
                'success' => false,
                'message' => 'Positions not found'
            ), 422);

        } catch (\Exception $e) {
        
            return response()->json(Array(
                'success'   => false,
                'message'   => $e->getMessage()
            ), 500);

        }

    }

}
