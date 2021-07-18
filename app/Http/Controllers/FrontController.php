<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\ContactUs;
use DB;

class FrontController extends Controller
{

    public function contact_us_store(Request $req){
        $req->validate([
            'name'=> 'required|max:100',
            'email'=> 'required|email',
            'subject'=> 'required|max:100',
            'message'=> 'required',
        ],
        [
            'name.required'=> 'Nama tidak boleh kosong.',
            'name.max'=> 'Nama tidak boleh lebih dari 100 karakter.',
            'email.required'=> 'Email tidak boleh kosong.',
            'email.email'=> 'Email tidak valid.',
            'subject.required'=> 'Subject tidak boleh kosong.',
            'subject.max'=> 'Subject tidak boleh lebih dari 100 karakter..',
            'message.required'=> 'Pesan tidak kosong.',
        ]);
        
        $contact_us = new ContactUs;
        $contact_us->name = $req->name;
        $contact_us->email = $req->email;
        $contact_us->subject = $req->subject;
        $contact_us->message = $req->message;

        if($contact_us->save()){
            return back()->with('sukses','Berhasil mengirim pesan!');
        }
        return back()->with('error','Gagal mengirim pesan!');
        
    }
    public function types_store(Request $req)
    {
        $types = DB::Table('types')->where('id',$req->get('id'))->first();
        return response()->json($types);
    }
}
