<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AutocompleteController extends Controller
{
    public function autocompleteApi(Request $request)
    {
        $query = $request->input('query');
        $apiKey = config('services.tomtom.api_key');

        $url = 'https://api.tomtom.com/search/2/search/' . urlencode($query) . '.json?typeahead=true&limit=30&countrySet=IT&key=' . $apiKey;

        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();
            return response()->json($data);
        } else {
            return response()->json(['error' => 'Failed to retrieve autocomplete suggestions']);
        }
    }
}
