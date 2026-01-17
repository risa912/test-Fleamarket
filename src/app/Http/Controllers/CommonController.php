<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class CommonController extends Controller
{
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $items = Item::query()
            ->where('name', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->get();

        return view('search.results', compact('items', 'keyword'));
    }
}
