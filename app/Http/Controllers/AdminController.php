<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use App\Models\User;
use App\Models\Address;
use App\Models\Type;
use App\Models\TypeBank;
use App\Models\StatusSell;
use App\Models\Wallet;
use App\Models\HistorySell;
use App\Models\ContactUs;
use App\Models\ContactUsReply;
use Auth;
use Hash;
use DB;
use Validator;
use Mail;

class AdminController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if(Auth::user()->role==1)
        {
            return redirect()->route('admin.index');
        }
        else if(Auth::user()->role==2)
        {
            return redirect()->route('driver.index');
        }
        $banks = DB::Table('banks')->get();
        $type_banks = DB::Table('type_banks')->get();

        $sell = DB::Table('sells')->orderBy('created_at','DESC')->get();
        $sell_asc = DB::Table('sells')->orderBy('created_at','ASC')->get();
        $history_sell = DB::Table('history_sells')->orderBy('created_at','DESC')->get();
        $history_payment = DB::Table('history_payments')->orderBy('created_at','DESC')->get();
        $history_payment_pending = DB::Table('history_payments')->where('status',0)->orderBy('created_at','DESC')->get();
        $history_payment_success = DB::Table('history_payments')->where('status',1)->orderBy('created_at','DESC')->get();
        $types = DB::Table('types')->get();
        $user = DB::Table('users')->orderBy('created_at','DESC')->get();
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
        $status_sell = DB::Table('status_sells')->get();
        return view('admin.index',[
            'sell' => $sell,
            'sell_asc' => $sell_asc,
            'status_sell'=>$status_sell,
            'types'=>$types,
            'addressing'=>$addressing,
            'history_sell' => $history_sell,
            'user' => $user,
            'bank' => $banks,
            'type_banks' => $type_banks,
            'history_payment' => $history_payment,
            'history_payment_pending' => $history_payment_pending,
            'history_payment_success' => $history_payment_success,
        ]);
    }
    public function store(Request $req)
    {
        if(isset($_POST['submit']))
        {
            $otw = HistorySell::Create([
                'id_sells' => $req->id,
                'id_users' => $req->id_users,
                'status' => $req->status,
            ]);
            $status = DB::Table('status_sells')->where('id',$req->status)->first();
            if($otw)
            {
                $data = DB::Table('sells')->where('id',$req->id)->first();
                $types = DB::Table('types')->get();
                $garbage = explode(',',$data->id_types);
                $qty = explode(',',$data->qty);
                $price = 0;
                $count = [];
                for($i=0;$i<count($garbage);$i++)
                {
                    foreach($types as $ty)
                    {
                        if($ty->id == $garbage[$i])
                        {
                            $price = $ty->price*$qty[$i];
                        }
                    }
                    array_push($count, $price);
                }
                $total = array_sum($count);
                $users = DB::Table('wallets')->where('id_users',$data->id_users)->first();
                $drivers = DB::Table('wallets')->where('id_users',$req->id_users)->first();
                $users_updated = DB::Table('wallets')->where('id_users',$data->id_users)->update([
                    'amount' => $users->amount+$total,
                ]);
                $drivers_updated = DB::Table('wallets')->where('id_users',$req->id_users)->update([
                    'amount' => $drivers->amount+$total/2,
                ]);
                if($users_updated && $drivers_updated)
                {
                    return back()->with('status','Berhasil mengubah status menjadi '.$status->name);
                }
            }
        }
        if(isset($_POST['cancel']))
        {
            $otw = HistorySell::Create([
                'id_sells' => $req->id,
                'id_users' => $req->id_users,
                'status' => 7,
            ]);
            $status = DB::Table('status_sells')->where('id',7)->first();
            if($otw)
            {
                return back()->with('status','Berhasil mengubah status menjadi '.$status->name);
            }
        }
        if(isset($_POST['withdrawal']))
        {
            $update = DB::Table('history_payments')->where('id',$req->id)->update([
                'status' => 1,
            ]);
            if($update)
            {
                return back()->with('withdrawal','Berhasil melakukan penarikan');
            }
        }
    }
    public function create_account()
    {
        $provinces = Province::pluck('name', 'id');
        return view('admin.create_account', [
            'provinces' => $provinces,
        ]);
    }
    public function create_account_store(Request $req)
    {
        $create_user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'role' => $req->role,
        ]);
        if($create_user)
        {
            if($req->role != 3)
            {
                $create_wallet = Wallet::create([
                    'id_users' => $create_user->id,
                ]);
            }
            if($req->addressed == TRUE)
            {
                $create_address = Address::create([
                    'id_users' => $create_user->id,
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
                    return back()->with('success', 'Berhasil menambahkan akun dan alamat');
                }
            }
            return back()->with('success', 'Berhasil menambahkan akun');
        }
    }
    public function list_account()
    {
        $account = User::all();
        $addresses = DB::Table('addresses')->where('status',1)->get();
        $provinces = Province::pluck('name', 'id');
        return view('admin.list_account',[
            'account'=>$account,
            'addresses'=>$addresses,
            'provinces'=>$provinces,
            ]);
    }
    public function profile_account($id)
    {
        $user = DB::Table('users')
                ->where('id',$id)
                ->first();
        $users = DB::Table('users')
                ->get();
        $addresses = DB::Table('addresses')
                    ->where('id_users',$id)
                    ->where('status',1)
                    ->get();
        $provinces = Province::pluck('name', 'id');
        $sell = DB::Table('sells')->orderBy('created_at','DESC')->get();
        $sell_user = DB::Table('sells')->where('id_users',$id)->orderBy('created_at','DESC')->get();
        $history_sell = DB::Table('history_sells')->orderBy('created_at','DESC')->get();
        $types = DB::Table('types')->get();
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
        $status_sell = DB::Table('status_sells')->get();
        return view('admin.profile_account',[
            'user'=>$user,
            'users'=>$users,
            'addresses'=>$addresses,
            'provinces'=>$provinces,
            'sell'=>$sell,
            'sell_user'=>$sell_user,
            'history_sell'=>$history_sell,
            'types'=>$types,
            'addressing'=>$addressing,
            'status_sell'=>$status_sell,
        ]);
    }
    public function profile_account_store(Request $req,$id)
    {
        if(isset($_POST['edit']))
        {
            return back()->with('edit','edit');
        }
        if(isset($_POST['edited']))
        {
            $profile = DB::Table('users')->where('id',$id)->update([
                'name' => $req->name,
                'email' => $req->email,
                'role' => $req->role,
            ]);
            if($req->add_address == TRUE)
            {
                $create_address = Address::create([
                    'id_users' => $id,
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
                    return back()->with('profile', 'Berhasil menambahkan alamat');
                }
            }
            if(!empty($req->name_address2))
            {
                $update_address = DB::Table('addresses')->where('id',$req->name_address2)->where('id_users',$id)->update([
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
                    return back()->with('profile','Berhasil melakukan perubahan');
                }
            }
            if($profile)
            {
                return back()->with('profile','Berhasil melakukan perubahan');
            }
            
            return back();
        }
    }
    public function profile_account_address_store(Request $req)
    {
        $addre = DB::Table('addresses')->where('id',$req->get('id'))->first();
        return response()->json($addre);
    }
    public function garbage()
    {
        $types = DB::Table('types')->where('status',1)->get();
        return view('admin.types_garbage',[
            'types'=>$types,
        ]);
    }
    public function garbage_store(Request $req)
    {
        if(isset($_POST['submit']))
        {
            $validator = Validator::make($req->all(), [
                'image.*' => 'mimes:jpg,jpeg,png,webp'
            ]); 
            if($req->id == NULL)
            {
                $name = 'img/sampah/'.strip_tags(str_replace(' ', '-', $req->type)).'_'.rand().'.'.$req->image->extension();
                $req->image->move(public_path('img/sampah'),$name);
                $create_type = Type::create([
                    'image' => $name,
                    'type' => $req->type,
                    'price' => $req->price,
                ]);
                if($create_type)
                {
                    return back()->with('garbage', 'Berhasil menambahkan jenis sampah');
                }
            }
            else
            {
                $id = $req->id;
                $data = DB::Table('types')->where('id',$id)->first();
                if($req->hasfile('image'))
                {
                    $name = 'img/sampah/'.strip_tags(str_replace(' ', '-', $req->type)).'_'.rand().'.'.$req->image->extension();
                    $req->image->move(public_path('img/sampah'),$name);
                    
                    if($data->price != $req->price || $data->type != $req->type)
                    {
                        DB::Table('types')->where('id',$id)->update([
                            'status' => false,
                        ]);
                        
                        $create_type = Type::create([
                            'image' => $name,
                            'type' => $req->type,
                            'price' => $req->price,
                        ]);
                        if($create_type)
                        {
                            return back()->with('garbage', 'Berhasil merubah jenis sampah');
                        }
                    }
                    else
                    {
                        $update_type = DB::Table('types')->where([
                            'id' => $req->id, 
                            ])->update([
                                'image' => $name,
                                'type' => $req->type,
                                'price' => $req->price,
                            ]);
                        if($update_type)
                        {
                            return back()->with('garbage', 'Berhasil merubah jenis sampah');
                        }
                    }
                }
                else
                {
                    if($data->price != $req->price || $data->type != $req->type)
                    {
                        DB::Table('types')->where('id',$id)->update([
                            'status' => false,
                        ]);
                        $create_type = Type::create([
                            'image' => $data->image,
                            'type' => $req->type,
                            'price' => $req->price,
                        ]);
                        if($create_type)
                        {
                            return back()->with('garbage', 'Berhasil merubah jenis sampah');
                        }
                    }
                    else
                    {
                        $update_type = DB::Table('types')->where([
                            'id' => $req->id, 
                            ])->update([
                                'type' => $req->type,
                                'price' => $req->price,
                            ]);
                        if($update_type)
                        {
                            return back()->with('garbage', 'Berhasil merubah jenis sampah');
                        }
                    }
                }
            }
        }
        if(isset($_POST['delete_garbage']))
        {
            if($req->id != NULL)
            {
                $delete_type = DB::Table('types')->where([
                    'id' => $req->id, 
                    ])->update([
                        'status' => 0,
                    ]);
                if($delete_type)
                {
                    return back()->with('garbage', 'Berhasil menghapus jenis sampah');
                }
            }
            return back();
        }
    }
    public function banks()
    {
        $types = DB::Table('type_banks')->where('status',1)->get();
        return view('admin.types_bank',[
            'types'=>$types,
        ]);
    }
    public function banks_store(Request $req)
    {
        if(isset($_POST['submit']))
        {
            if($req->id == NULL)
            {
                $create_type = TypeBank::create([
                    'name' => $req->name,
                ]);
                if($create_type)
                {
                    return back()->with('bank', 'Berhasil menambahkan nama bank');
                }
            }
            else
            {
                $update_type = DB::Table('type_banks')->where([
                    'id' => $req->id, 
                    ])->update([
                        'name' => $req->name,
                    ]);
                if($update_type)
                {
                    return back()->with('bank', 'Berhasil merubah nama bank');
                }
            }
        }
        if(isset($_POST['delete_bank']))
        {
            if($req->id != NULL)
            {
                $delete_type = DB::Table('type_banks')->where([
                    'id' => $req->id, 
                    ])->update([
                        'status' => 0,
                    ]);
                if($delete_type)
                {
                    return back()->with('bank', 'Berhasil menghapus nama bank');
                }
            }
            return back();
        }
    }
    public function status_sells()
    {
        $status = DB::Table('status_sells')->get();
        return view('admin.status_sells',[
            'status'=>$status,
        ]);
    }
    public function status_sells_store(Request $req)
    {
        if(isset($_POST['submit']))
        {
            if($req->id == NULL)
            {
                $create_type = StatusSell::create([
                    'name' => $req->name,
                ]);
                if($create_type)
                {
                    return back()->with('status', 'Berhasil menambahkan nama status');
                }
            }
            else
            {
                $update_status = DB::Table('status_sells')->where([
                    'id' => $req->id, 
                    ])->update([
                        'name' => $req->name,
                    ]);
                if($update_status)
                {
                    return back()->with('status', 'Berhasil merubah nama status');
                }
            }
        }
    }

    public function contact_us_list()
    {
        $data = DB::table('contact_us')
            ->orderBy('id', 'desc')
            ->get();
        
        $jml = count($data);
        
        return view('admin.contact_us.list_pesan', compact('data', 'jml'));
    }
    
    public function contact_us_reply($id_contact)
    {
        $data = DB::table('contact_us')
            ->where('id', '=', $id_contact)
            ->first();

        return view('admin.contact_us.reply_pesan', compact('data'));
    }
    
    public function contact_us_reply_store(Request $req)
    {
        $id_contact = $req->id;
        $req->validate([
            'subject'=> 'required|max:100',
            'message'=> 'required',
        ],
        [
            'subject.required'=> 'Subject tidak boleh kosong.',
            'subject.max'=> 'Subject tidak boleh lebih dari 100 karakter..',
            'message.required'=> 'Pesan tidak kosong.',
        ]);
        
        $contact_us = new ContactUsReply;
        $contact_us->id_contact_us = $id_contact;
        $contact_us->id_users = Auth::user()->id;
        $contact_us->subject = $req->subject;
        $contact_us->message = $req->message;

        // update status contact_us
        $update = DB::table('contact_us')
            ->where([
                ['id', '=', $id_contact],
            ])->update([
                'is_reply' => 1,
            ]);

        if($contact_us->save()){
            Mail::send('email',[
                'subjek' => $req->subject,
                'pesan' => nl2br($req->message),
            ],
                function($message) use ($req)
                {
                    $message->subject('PickyTrash: '.$req->subject);
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $message->to($req->email);
                });
            return redirect()->route('admin.contact_us_list')->with('sukses','Berhasil mengirim balasan!');
        }
        return redirect()->route('admin.contact_us_list')->with('error','Gagal mengirim balasan!');
    }

    public function list_reply()
    {
        $data = DB::table('contact_us_reply')
            ->join('users','contact_us_reply.id_users','=','users.id')
            ->select(
                'users.*',
                'contact_us_reply.*',
                'id_users as users.id',
                'users.name as user_name',
            )
            ->orderBy('contact_us_reply.id', 'desc')
            ->get();
        
        $jml = count($data);

        return view('admin.contact_us.list_reply_pesan', compact('data', 'jml'));
    }

    public function reply_detail($id)
    {
        $data = DB::table('contact_us_reply')
            ->join('users','contact_us_reply.id_users','=','id_users')
            ->join('contact_us','contact_us_reply.id_contact_us','=','id_contact_us')
            ->select(
                'users.*',
                'contact_us_reply.*',
                'contact_us.id as id_contact_us',
                'users.id as id_users',
                'users.name as user_name',
                'contact_us.name as name_contact_us',
                'contact_us.email as email_contact_us',
                'contact_us.subject as subject_contact_us',
                'contact_us.message as message_contact_us',
            )
            ->where('contact_us_reply.id', '=', $id)
            ->first();

        return view('admin.contact_us.reply_detail', compact('data'));
    }

}
