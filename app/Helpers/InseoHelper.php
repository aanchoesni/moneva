<?php

namespace App\Helpers;

use DB;
use Session;
use App\Models\MasterRba;

class InseoHelper
{
    public static function tglbulanindo2($waktu, $tipe = '')
    {
        $menit = substr($waktu, 14, 2);
        $jam = substr($waktu, 11, 2);
        $tgl = substr($waktu, 8, 2);
        $bln = substr($waktu, 5, 2);
        $thn = substr($waktu, 0, 4);
        $bulan = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember');
        $idxhari = date('N', strtotime($waktu));

        switch ($tipe) {
          case 1:$full = $tgl.' '.$bulan[(int) $bln - 1].' '.$thn;
              break;
          case 2:$full = $tgl.'/'.$bln.'/'.$thn;
              break;
          default:$full = "$tgl ".$bulan[(int) $bln - 1]." $thn";
        }

        return $full;
    }

    public static function tgl($waktu)
    {
        $tgl = substr($waktu, 8, 2);
        $bln = substr($waktu, 5, 2);
        $thn = substr($waktu, 0, 4);

        $full = $tgl.' - '.$bln.' - '.$thn;

        return $full;
    }

    public static function child($induk)
    {
      $child = MasterRba::orderBy('no_rba', 'asc')->where('no_rba_induk', $induk)->get();

      return $child;
    }
}
