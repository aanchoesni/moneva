<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterRba extends Model
{
  public $incrementing = false;

  protected $table = 'master_rba';

  public static $rules = [
      'unit_kerja' => 'required',
      'no_rba' => 'required',
      'program' => 'required',
      'sub_program' => 'required',
      'anggaran_pagu' => 'required',
      'anggaran_terserap' => 'required',
      'anggaran_sisa' => 'required',
      'jadwal_pelaksanaan' => 'required',
      'keterangan' => 'required'
  ];

  public static $errormessage = [
      'unit_kerja' => 'Pilih Unit kerja',
      'no_rba' => 'Pilih Nomor RBA',
      'program' => 'Pilih Program/Kegiatan',
      'sub_program' => 'Pilih Sub Program/ Sub Kegiatan',
      'anggaran_pagu' => 'Pilih Pagu',
      'anggaran_terserap' => 'Pilih Anggaran Terserap',
      'anggaran_sisa' => 'Pilih Sisa Anggaran',
      'jadwal_pelaksanaan' => 'Pilih jadwal Pelaksanaan'
  ];

  protected $fillable = [
      'id', 'unit_kerja', 'no_rba_induk', 'no_rba', 'program', 'sub_program', 'anggaran_pagu', 'anggaran_terserap', 'anggaran_sisa', 'anggaran_persen', 'target', 'satuan', 'realisasi', 'total_progres', 'jadwal_pelaksanaan', 'tahun', 'keterangan', 'userid_created', 'userid_updated'
  ];
}
