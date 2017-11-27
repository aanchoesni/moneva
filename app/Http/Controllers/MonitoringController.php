<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterRba;
use App\Models\Output;
use DB;

class MonitoringController extends Controller
{
    public function index()
    {
      $data = DB::select('SELECT unit.unit, MONTH (tgl_digunakan) AS bulan FROM output RIGHT JOIN unit ON output.unit = unit.unit GROUP BY unit.unit, bulan ORDER BY unit.unit ASC');

      $vardat = [];
      $v = [];
      foreach ($data as $value) {
        $v[str_replace(' ', '', $value->unit)][$value->bulan] = 1;
      }

      for ($i=1; $i <= 12; $i++) {
        foreach ($data as $value) {
          if (array_key_exists($i, $v[str_replace(' ', '', $value->unit)])) {
            $vardat[str_replace(' ', '', $value->unit)][$i] = 1;
          } else {
            $vardat[str_replace(' ', '', $value->unit)][$i] = 0;
          }
        }
      }

      return view('monitoring.index', compact('vardat'));
    }
}
