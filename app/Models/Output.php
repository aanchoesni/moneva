<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Output extends Model
{
  public $incrementing = false;

  protected $table = 'output';

  public static $rules = [
      'keterangan' => 'required',
      'terserap' => 'required',
      'realisasi' => 'required',
      'tgl_digunakan' => 'required'

  ];

  public static $errormessage = [
      'keterangan' => 'Tidak boleh kosong',
      'terserap' => 'Tidak boleh kosong',
      'realisasi' => 'Tidak boleh kosong',
      'tgl_digunakan' => 'Tidak boleh kosong'

  ];

  protected $fillable = [
      'id', 'keterangan', 'rba', 'terserap', 'realisasi', 'tgl_digunakan', 'userid_created', 'userid_updated', 'unit',

  ];
}
