<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public static $rules = [
      'name' => 'required',
      'email' => 'required',
      'password' => 'required',
      'password_confirmation' => 'required',
    ];

    public static $errormessage = [
      'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
    ];

    protected $fillable = [
        'id', 'name', 'email', 'password', 'role', 'is_active', 'unit',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
