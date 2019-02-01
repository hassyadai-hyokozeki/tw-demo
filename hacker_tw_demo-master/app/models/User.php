<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // これはDBクラスを利用しているがEloquentでリプレイス出来たのでそっちを使う。
    // public function getUsers($where = null, $join = null, $select = null) {
    //     $users = DB::table('users');
    //
    //     $users->select($select);
    //
    //     foreach ($join as $value) {
    //         $users->{$value['joinType']}($value['tableName'], $value['joinCondition']);
    //     }
    //
    //     if (!empty($where)) {
    //         $users->where($where);
    //     }
    //
    //     return $users->orderByRaw('users.created_at DESC')->get();
    // }

}
