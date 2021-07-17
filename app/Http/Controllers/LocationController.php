<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;

class LocationController extends Controller
{
    //
    public function province_store(Request $request)
    {
        $cities = Province::pluck('name', 'id', 'meta');

        return response()->json($cities);
    }
    public function city_store(Request $request)
    {
        $cities = City::where('province_id', $request->get('id'))
            ->pluck('name', 'id', 'meta');

        return response()->json($cities);
    }

    public function district_store(Request $request)
    {
        $district = District::where('city_id', $request->get('id'))
            ->pluck('name', 'id', 'meta');

        return response()->json($district);
    }

    public function village_store(Request $request)
    {
        $village = Village::where('district_id', $request->get('id'))
            ->pluck('name', 'id', 'meta');

        return response()->json($village);
    }
}
