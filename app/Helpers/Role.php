<?php
namespace App\Helpers;
 
use Illuminate\Support\Facades\DB;
use Auth; 

class Role {
    public static function is() {
        $roles = '';
        if(Auth::check())
        {
            $auth = DB::Table('users')->where('id',Auth::user()->id)->first();
            if($auth->role == 1)
            {
                $roles = "user";
            }
            else if($auth->role == 2)
            {
                $roles = "driver";
            }
            else if($auth->role == 3)
            {
                $roles = "admin";
            }
            $role = $roles;
            return (isset($role) ? $role : '');
        }
    }
}