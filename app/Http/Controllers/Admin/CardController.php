<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CardController extends Controller
{
    public function index (Request $request) {
        return view('admin.card.index');
    }
    public function create (Request $request) {
        return view('admin.card.create');
    }
    public function edit (Request $request, $id) {
        $card_id = $id;
        return view('admin.card.edit', compact('card_id'));
    }
    
}
