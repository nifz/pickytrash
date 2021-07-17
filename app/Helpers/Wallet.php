<?php
namespace App\Helpers;
 
use Illuminate\Support\Facades\DB;
use Auth; 

class Wallet {
    public static function amount($id_users) {
        $wallet = DB::table('wallets')->where('id_users', $id_users)->first();
        return (isset($wallet->amount) ? $wallet->amount : '');
    }
}