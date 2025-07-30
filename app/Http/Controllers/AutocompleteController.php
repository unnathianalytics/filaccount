<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AutocompleteController extends Controller
{
    public function items(Request $request)
    {
        // Existing method for item autocomplete
        $term = $request->input('term');
        $items = \App\Models\Item::where('name', 'LIKE', "%{$term}%")
            ->take(10)
            ->get(['id as value', 'name as label']);
        return response()->json($items);
    }
}
