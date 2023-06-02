<?php

use App\Models\Airline;
use App\Models\Airport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

Route::get('/airline', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'code' => 'required'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'error' => 'Missing required code parameter.'
        ], 400);
    }

    return Airline::where('IATA', $request->code)->first();
});


Route::get('/airports', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'country' => 'required'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'error' => 'Missing required country parameter.'
        ], 400);
    }

    $country = $request->input('country');

    $airports = Airport::where('countryName', 'like', "%$country%")
        ->orWhere('name', 'like', "%$country%")
        ->orWhere('code', 'like', "%$country%")
        ->get();


    return response()->json($airports);
});
