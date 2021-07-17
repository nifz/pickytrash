<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Hash;
use Validator;
use App\Models\User;
use App\Models\Address;
use App\Models\Bank;
use App\Models\TypeBank;
use App\Models\HistoryPayment;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use Laravolt\Indonesia\Models\Type;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function settings()
    {
        $user = User::where('id',Auth::user()->id);
        $provinces = Province::pluck('name', 'id');
        $address = DB::Table('addresses')->where(['id_users' => Auth::user()->id, 'status' => 1,])->get();
        $bank = DB::Table('banks')->where('id_users',Auth::user()->id)->get();
        $type_bank = DB::Table('type_banks')->where('status',1)->get();
        return view('settings',[
            'user' => $user,
            'provinces' => $provinces,
            'address' => $address,
            'bank' => $bank,
            'type_bank' => $type_bank,
        ]);
    }
}
