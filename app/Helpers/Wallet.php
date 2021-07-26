<?php
namespace App\Helpers;
 
use Illuminate\Support\Facades\DB;
use Auth; 

class Wallet {
    public static function amount($id_users) {
        $wallet = DB::table('wallets')->where('id_users', $id_users)->first();
        return (isset($wallet->amount) ? $wallet->amount : '');
    }
    public static function withdrawal($id_users) {
        $bank = DB::Table('banks')->where('id_users',$id_users)->get();
        $history = DB::Table('history_payments')->get();
        $i = 0;
        foreach($bank as $b)
        {
            foreach($history as $h)
            {
                if($b->id == $h->id_banks)
                {
                    $i++;
                }
            }
        }
        return $i;
    }
}