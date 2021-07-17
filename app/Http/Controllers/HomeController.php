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
    public function settings_store(Request $req)
    {
        if(isset($_POST['change_profile']))
        {
            $validator = Validator::make($req->all(), [
                'image.*' => 'mimes:jpg,jpeg,png,webp'
            ]); 

            if($req->hasfile('image'))
            {
                $name = 'assets/images/'.strip_tags(str_replace(' ', '-', $req->name)).'_'.rand().'.'.$req->image->extension();
                $req->image->move(public_path('assets/images'),$name);
                $profile = DB::table('users')->where('id',Auth::user()->id)->update([
                    'name' => $req->name,
                    'email' => $req->email,
                    'photo'=>$name,
                ]);
                if($profile)
                {
                    return back()->with('profile','Berhasil melakukan perubahan');
                }
            }
            $profile = DB::Table('users')->where('id',Auth::user()->id)->update([
                'name' => $req->name,
                'email' => $req->email,
            ]);
            if($profile)
            {
                return back()->with('profile','Berhasil melakukan perubahan');
            }
            return back();
        }
        if(isset($_POST['change_password']))
        {
            $value = $req->password_old;
            $validator = $req->validate([
                'password_old' => [
                    'required', function ($attribute, $value, $fail) {
                        if (!Hash::check($value, Auth::user()->password)) {
                            $fail('Old Password didn\'t match');
                        }
                    },
                ],
                'password' => 'required|string|min:8|confirmed',
            ]);
            $password = DB::Table('users')->where('id',Auth::user()->id)->update([
                'password' => Hash::make($req->password),
            ]);
            if($password)
            {
                return back()->with('password', 'Berhasil merubah password');
            }
        }
        if(isset($_POST['submit']))
        {
            if($req->id_address == NULL)
            {
                $create_address = Address::create([
                    'id_users' => Auth::user()->id,
                    'phone' => $req->phone,
                    'id_provinces' => $req->province,
                    'id_cities' => $req->city,
                    'id_districts' => $req->district,
                    'id_villages' => $req->village,
                    'name' => $req->name_address,
                    'address' => $req->address,
                    'postal_code' => $req->postalcode,
                ]);
                if($create_address)
                {
                    return back()->with('address', 'Berhasil menambahkan alamat');
                }
            }
            else
            {
                $update_address = DB::Table('addresses')->where([
                    'id' => $req->id_address, 
                    'id_users' => Auth::user()->id,
                    ])->update([
                        'phone' => $req->phone,
                        'id_provinces' => $req->province,
                        'id_cities' => $req->city,
                        'id_districts' => $req->district,
                        'id_villages' => $req->village,
                        'name' => $req->name_address,
                        'address' => $req->address,
                        'postal_code' => $req->postalcode,
                    ]);
                if($update_address)
                {
                    return back()->with('address', 'Berhasil merubah alamat');
                }
            }
            return back();
        }
        if(isset($_POST['delete_address']))
        {
            if($req->id_address != NULL)
            {
                $delete_address = DB::Table('addresses')->where([
                    'id' => $req->id_address, 
                    'id_users' => Auth::user()->id,
                    ])->update([
                        'status' => 0,
                    ]);
                if($delete_address)
                {
                    return back()->with('address', 'Berhasil menghapus alamat');
                }
            }
            return back();
        }
        if(isset($_POST['submit_bank']))
        {
            if($req->id == NULL)
            {
                $create_bank = Bank::create([
                    'id_users' => Auth::user()->id,
                    'id_type_banks' => $req->type_bank,
                    'number' => $req->number_bank,
                    'status' => 1,
                ]);
                if($create_bank)
                {
                    return back()->with('bank', 'Berhasil menambahkan rekening');
                }
            }
            else
            {
                $update_bank = DB::Table('banks')->where([
                    'id' => $req->id, 
                    'id_users' => Auth::user()->id,
                    ])->update([
                        'id_type_banks' => $req->type_bank,
                        'number' => $req->number_bank,
                    ]);
                if($update_bank)
                {
                    return back()->with('bank', 'Berhasil merubah rekening');
                }
            }
            return back();
        }
        if(isset($_POST['delete_bank']))
        {
            if($req->id != NULL)
            {
                $delete_bank = DB::Table('banks')->where([
                    'id' => $req->id, 
                    'id_users' => Auth::user()->id,
                    ])->update([
                        'status' => 0,
                    ]);
                if($delete_bank)
                {
                    return back()->with('bank', 'Berhasil menghapus rekening');
                }
            }
            return back();
        }
    }
}
