<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Hash;
use App\Models\User;
use App\Models\Address;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use Laravolt\Indonesia\Models\Type;
use App\Models\Sell;
use App\Models\HistorySell;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $provinces = Province::pluck('name', 'id', 'meta');
        $cities = City::pluck('name', 'id', 'meta');
        $districts = District::pluck('name', 'id', 'meta');
        $villages = Village::pluck('name', 'id', 'meta');
        $types = DB::Table('types')->get();
        $sell = DB::Table('sells')->where('id_users',Auth::user()->id)->orderBy('created_at','DESC')->get();
        $history_sell = DB::Table('history_sells')->orderBy('created_at','DESC')->get();
        $user = DB::Table('users')->where('role','2')->get();
        $status_sell = DB::Table('status_sells')->get();
        $addresses = DB::Table('addresses')
                    ->where('id_users',Auth::user()->id)
                    ->where('status',1)
                    ->get(); 
        $addressing = DB::Table('addresses')
        ->join('indonesia_provinces','addresses.id_provinces','=','indonesia_provinces.id')
        ->join('indonesia_cities','addresses.id_cities','=','indonesia_cities.id')
        ->join('indonesia_districts','addresses.id_districts','=','indonesia_districts.id')
        ->join('indonesia_villages','addresses.id_villages','=','indonesia_villages.id')
        ->select(
            'addresses.*','addresses.id as id_address',
            'indonesia_provinces.name as province_name','indonesia_provinces.meta as province_meta',
            'indonesia_cities.name as cities_name','indonesia_cities.meta as cities_meta',
            'indonesia_districts.name as districts_name','indonesia_districts.meta as districts_meta',
            'indonesia_villages.name as villages_name','indonesia_villages.meta as villages_meta',
        )
        ->get();
        return view('user.index',[
            'provinces'=>$provinces,
            'cities'=>$cities,
            'districts'=>$districts,
            'villages'=>$villages,
            'addresses'=>$addresses,
            'types'=>$types,
            'sell'=>$sell,
            'history_sell'=>$history_sell,
            'user'=>$user,
            'addressing'=>$addressing,
            'status_sell'=>$status_sell,
        ]);
    }
    public function store(Request $req)
    {
        if(isset($_POST['cancel']))
        {
            $id = $req->id;
            Sell::whereId($id)->delete();
            HistorySell::whereIdSells($id)->delete();
            return back();
        }
        $sell = Sell::create([
            'id_users' => Auth::user()->id,
            'id_addresses' => $req->address,
            'id_types' => implode(',', $req->garbage),
            'qty' => implode(',', $req->qty),
        ]);
        $history_sell = HistorySell::create([
            'id_sells' => $sell->id,
            'status' => 1,
        ]);
        return back()->with('sell','Berhasil mengajukan penjualan');
    }
    public function types_store(Request $req)
    {
        $types = DB::Table('types')->where('id',$req->get('id'))->first();
        return response()->json($types);
    }
    public function profile_account_address_store(Request $req)
    {
        $addre = DB::Table('addresses')
                ->join('indonesia_provinces','addresses.id_provinces','=','indonesia_provinces.id')
                ->join('indonesia_cities','addresses.id_cities','=','indonesia_cities.id')
                ->join('indonesia_districts','addresses.id_districts','=','indonesia_districts.id')
                ->join('indonesia_villages','addresses.id_villages','=','indonesia_villages.id')
                ->select(
                    'addresses.*',
                    'indonesia_provinces.name as province_name','indonesia_provinces.meta as province_meta',
                    'indonesia_cities.name as cities_name','indonesia_cities.meta as cities_meta',
                    'indonesia_districts.name as districts_name','indonesia_districts.meta as districts_meta',
                    'indonesia_villages.name as villages_name','indonesia_villages.meta as villages_meta',
                    )
                ->where('addresses.id',$req->get('id'))
                ->first();
        return response()->json($addre);
    }
}
