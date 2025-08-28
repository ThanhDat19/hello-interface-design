<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CardTypeResource;
use App\Models\CardType;

class CardTypeAPIController extends Controller
{
    public function getDataHandle(Request $request) {
        $data = CardType::orderBy('card_type_name')->get();
        $data = CardTypeResource::collection($data);
        return response()->json([
            'success' => true,
            'code'    => 200,
            'data'    => $data,
        ]);
    }
}
