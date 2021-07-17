<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Hash;
use App\Models\User;
use App\Models\Address;
use App\Models\HistorySell;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use Laravolt\Indonesia\Models\Type;

class DriverController extends Controller
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
        $sell = DB::Table('sells')->orderBy('created_at','DESC')->get();
        $history_sell = DB::Table('history_sells')->orderBy('created_at','DESC')->get();
        $user = DB::Table('users')->get();
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
        return view('driver.index',[
            'provinces'=>$provinces,
            'cities'=>$cities,
            'districts'=>$districts,
            'villages'=>$villages,
            'addresses'=>$addresses,
            'addressing'=>$addressing,
            'types'=>$types,
            'sell'=>$sell,
            'status_sell'=>$status_sell,
            'history_sell'=>$history_sell,
            'user'=>$user,
        ]);
    }
    public function store(Request $req)
    {
        if(isset($_POST['removed']))
        {
            $delete = DB::Table('history_sells')->where([
                ['id_sells','=',$req->id],
                ['id_users','=',Auth::user()->id],
                ['status','!=',1],
                ])->delete();
            if($delete)
            {
                $update = DB::Table('history_sells')->where([
                    'id_sells'=>$req->id,
                    'status'=>1,
                ])->update([
                    'id_users'=>NULL,
                ]);
                if($update)
                {
                    return back()->with('status','Berhasil membatalkan pengambilan sampah');
                }
            }
        }
        if(isset($_POST['submit']))
        {
            $update = DB::Table('history_sells')->where('id_sells',$req->id)->update([
                'id_users' => Auth::user()->id,
            ]);
            $otw = HistorySell::Create([
                'id_sells' => $req->id,
                'id_users' => Auth::user()->id,
                'status' => $req->status,
            ]);
            $status = DB::Table('status_sells')->where('id',$req->status)->first();
            if($otw)
            {
                return back()->with('status','Berhasil mengubah status menjadi '.$status->name);
            }
        }
        if(isset($_POST['cancel']))
        {
            $otw = HistorySell::Create([
                'id_sells' => $req->id,
                'id_users' => Auth::user()->id,
                'status' => 7,
            ]);
            $status = DB::Table('status_sells')->where('id',7)->first();
            if($otw)
            {
                return back()->with('status','Berhasil mengubah status menjadi '.$status->name);
            }
        }
    }
}
