<?php

namespace App\Http\Controllers;

use App\Models\Output;
use Illuminate\Http\Request;
use App\Models\MasterRba;
use Session;
use Validator;
use Alert;
use Uuid;
use Crypt;
use Excel;

class OutputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detil($rba)
    {
      Session::put('ss_rbaid', $rba);
      $data = Output::where('rba', $rba)->get();
      $induk = MasterRba::where('id', $rba)->first();
      Session::put('ss_unitkerja', $induk->unit_kerja);

      return view('output.detil', compact('data', 'induk'));
    }

    public function index(Request $request)
    {
      // dd($request->input('tahun'));
      if (!Session::has('ss_adm_tahun')) {
        Session::put('ss_adm_tahun', Date('Y'));
      } else if (Session::has('ss_adm_tahun')) {
        $txtahun = $request->input('tahun');
        Session::put('ss_adm_tahun', $txtahun);
      }

      if (!Session::has('ss_adm_unit')) {
        Session::put('ss_adm_unit', 'fakultas');
      } else if (Session::has('ss_adm_unit')) {
        $txunit = $request->input('unit');
        Session::put('ss_adm_unit', $txunit);
      }

      $filter = strtolower($request->input('filter'));
      Session::put('ss_adm_filter', $filter);

      $tahun = MasterRba::groupBy('tahun')->pluck('tahun', 'tahun');
      $unit = MasterRba::whereNotNull('unit_kerja')->groupBy('unit_kerja')->pluck('unit_kerja', 'unit_kerja');
      $unit->prepend('Fakultas', 'fakultas');

      $data = MasterRba::orderBy('no_rba', 'asc')->whereNotNull('unit_kerja');

      if (Session::get('ss_adm_unit') != 'fakultas') {
        $data = $data->where('unit_kerja', Session::get('ss_adm_unit'));
      }

      if (Session::get('ss_adm_tahun')) {
        $data = $data->where('tahun', Session::get('ss_adm_tahun'));
      }

      if(Session::get('ss_adm_filter') != null || Session::get('ss_adm_filter') != ''){
        $data = $data->WhereRaw("lower(sub_program) LIKE '%$filter%'");
      }
      $data = $data->get();

      return view('output.index', compact('data', 'tahun', 'unit'));
    }

    public function jurusan(Request $request)
    {
      $txunit = Session::get('ss_unit');
      $filter = strtolower($request->input('filter'));

      if (!Session::has('ss_adm_tahun')) {
        Session::put('ss_adm_tahun', Date('Y'));
      } else {
        $txtahun = $request->input('tahun');
        Session::put('ss_adm_tahun', $txtahun);
      }

      Session::put('ss_adm_unit', $txunit);
      Session::put('ss_adm_filter', $filter);

      $tahun = MasterRba::groupBy('tahun')->pluck('tahun', 'tahun');

      $data = MasterRba::orderBy('program', 'asc')->where('unit_kerja', Session::get('ss_adm_unit'))->where('tahun', Session::get('ss_adm_tahun'))->whereNotNull('unit_kerja');
      if (Session::get('ss_adm_filter') != null || Session::get('ss_adm_filter') != '') {
        $data = $data->WhereRaw("lower(sub_program) LIKE '%$filter%'");
      }
      $data = $data->get();

      return view('output.jurusan', compact('data', 'tahun'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $rbaid = Session::get('ss_rbaid');
      $cekanggaran = MasterRba::where('id', $rbaid)->first();

      if ($cekanggaran->anggaran_pagu == $cekanggaran->anggaran_terserap) {
        Alert::warning('Anggaran habis digunakan')->persistent('Ok');
        return redirect()->back();
      }

      return view('output.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = $request->except('_token');
      $validator = Validator::make($data, Output::$rules, Output::$errormessage);

      if ($validator->fails()) {
          $errormessage = $validator->messages();
          return redirect()->back()->withErrors($validator)->withInput();
      }

      $rbaid = Session::get('ss_rbaid');
      $cekpagu = Masterrba::where('id', $rbaid)->first();
      $tmppagu = $cekpagu->anggaran_terserap+(int)$request->input('terserap');

      if ($cekpagu->anggaran_pagu<$tmppagu) {
        Alert::warning('Anggaran terlalu besar', 'Dana tidak mencukupi')->persistent('Ok');
        return redirect()->back()->withInput();
      }

      $uuid = Uuid::generate();

      $data['id'] = $uuid;
      $data['rba'] = $rbaid;
      $data['tgl_digunakan'] = date('Y-m-d', strtotime($request->input('tgl_digunakan')));
      $data['unit'] = Session::get('ss_unitkerja');
      $data['userid_created'] = Session::get('ss_nama');
      $data['userid_updated'] = Session::get('ss_nama');
      Output::create($data);

      $anggaran_sisa = $cekpagu->anggaran_pagu - $tmppagu;
      $anggaran_persen = ((int)$tmppagu/(int)$cekpagu->anggaran_pagu)*100;

      $realisasi = $cekpagu->realisasi + $request->input('realisasi');
      $total_progres = ((int)$realisasi/(int)$cekpagu->target)*100;

      $child = MasterRba::findOrFail($rbaid);
      $datamr['anggaran_terserap'] = $tmppagu;
      $datamr['anggaran_sisa'] = $anggaran_sisa;
      $datamr['anggaran_persen'] = $anggaran_persen;
      $datamr['realisasi'] = $realisasi;
      $datamr['total_progres'] = $total_progres;
      $datamr['userid_updated'] = Session::get('ss_nama');
      $child->update($datamr);

      // dd($child->program);

      $head = MasterRba::where('no_rba', $child->no_rba_induk)->first();
      $anggaran_terserap_induk = $head->anggaran_terserap + (int)$request->input('terserap');
      $anggaran_sisa_induk = $head->anggaran_pagu - (int)$request->input('terserap');
      $anggaran_persen_induk = ((int)$anggaran_terserap_induk / (int)$head->anggaran_pagu) * 100;
      $datainduk['anggaran_terserap'] = $anggaran_terserap_induk;
      $datainduk['anggaran_sisa'] = $anggaran_sisa_induk;
      $datainduk['anggaran_persen'] = $anggaran_persen_induk;
      $head->update($datainduk);

      Alert::success('Successfully save data')->persistent('Ok');

      return redirect()->route('detil_output', ['data'=>Session::get('ss_rbaid')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Output  $output
     * @return \Illuminate\Http\Response
     */
    public function show(Output $output)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Output  $output
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      try {
        $output = Output::find(Crypt::decrypt($id));

        return View('output.edit', compact('output'));
      } catch (\Exception $id) {
        return redirect()->route('detil_output', ['data'=>Session::get('ss_rbaid')]);
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Output  $output
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $output = Output::findOrFail($id);
      $oldoutput = $output;

      $data = $request->except('_token');
      $validator = Validator::make($data, Output::$rules, Output::$errormessage);

      if ($validator->fails()) {
          $errormessage = $validator->messages();
          return redirect()->back()->withErrors($validator)->withInput();
      }

      $cekpagu = Masterrba::where('id', $output->rba)->first();
      $tmppagu = ((int)$cekpagu->anggaran_terserap - (int)$output->terserap) + (int)$request->input('terserap');
      $realisasi = ((int)$cekpagu->realisasi-(int)$output->realisasi) + (int)$request->input('realisasi');

      if ($cekpagu->anggaran_pagu<$tmppagu) {
        Alert::warning('Anggaran terlalu besar', 'Dana tidak mencukupi')->persistent('Ok');
        return redirect()->back()->withInput();
      }

      $anggaran_sisa = ($output->terserap+$cekpagu->anggaran_sisa) - $tmppagu;
      $anggaran_persen = ((int)$tmppagu/(int)$cekpagu->anggaran_pagu)*100;

      $total_progres = ((int)$realisasi/(int)$cekpagu->target)*100;

      $data['tgl_digunakan'] = date('Y-m-d', strtotime($request->input('tgl_digunakan')));
      $data['userid_updated'] = Session::get('ss_nama');

      $child = MasterRba::findOrFail($output->rba);
      $datamr['anggaran_terserap'] = $tmppagu;
      $datamr['anggaran_sisa'] = $anggaran_sisa;
      $datamr['anggaran_persen'] = $anggaran_persen;
      $datamr['realisasi'] = $realisasi;
      $datamr['total_progres'] = $total_progres;
      $datamr['userid_updated'] = Session::get('ss_nama');

      $head = MasterRba::where('no_rba', $child->no_rba_induk)->first();
      $anggaran_terserap_induk = ((int)($head->anggaran_terserap - (int)$oldoutput->terserap)) + (int)$request->input('terserap');
      $anggaran_sisa_induk = ((int)$head->anggaran_sisa + (int)$oldoutput->terserap) - (int)$request->input('terserap');
      $anggaran_persen_induk = ((double)$anggaran_terserap_induk / (double)$head->anggaran_pagu) * 100;
      // dd($anggaran_terserap_induk);

      $datainduk['anggaran_terserap'] = $anggaran_terserap_induk;
      $datainduk['anggaran_sisa'] = $anggaran_sisa_induk;
      $datainduk['anggaran_persen'] = $anggaran_persen_induk;
      $datainduk['userid_updated'] = Session::get('ss_nama');

      $head->update($datainduk);
      $child->update($datamr);
      $output->update($data);

      Alert::success('Successfully Update Data')->persistent('Ok');
      return redirect()->route('detil_output', ['data'=>Session::get('ss_rbaid')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Output  $output
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      try {
        $outputdata = Output::where('id', Crypt::decrypt($id))->first();
        $rbaid = $outputdata->rba;
        $masterdata = MasterRba::where('id', $rbaid)->first();

        $tmppagu = $masterdata->anggaran_terserap-$outputdata->terserap;
        $anggaran_sisa = $masterdata->anggaran_sisa+$outputdata->terserap;
        $anggaran_persen = ((int)$tmppagu/(int)$masterdata->anggaran_pagu)*100;

        $tmprealisasi = $masterdata->realisasi - $outputdata->realisasi;
        $total_progres = $total_progres = ((int)$tmprealisasi / (int)$masterdata->target) * 100;

        $datamr['anggaran_terserap'] = $tmppagu;
        $datamr['anggaran_sisa'] = $anggaran_sisa;
        $datamr['anggaran_persen'] = $anggaran_persen;
        $datamr['realisasi'] = $tmprealisasi;
        $datamr['total_progres'] = $total_progres;
        $datamr['userid_updated'] = Session::get('ss_nama');
        $masterdata->update($datamr);

        $head = MasterRba::where('no_rba', $masterdata->no_rba_induk)->first();

        $anggaran_terserap_induk = ((int) ($head->anggaran_terserap - (int)$outputdata->terserap));
        $anggaran_sisa_induk = ((int)$head->anggaran_sisa + (int)$outputdata->terserap);
        $anggaran_persen_induk = ((double)$anggaran_terserap_induk / (double)$head->anggaran_pagu) * 100;

        $datainduk['anggaran_terserap'] = $anggaran_terserap_induk;
        $datainduk['anggaran_sisa'] = $anggaran_sisa_induk;
        $datainduk['anggaran_persen'] = $anggaran_persen_induk;
        $datainduk['userid_updated'] = Session::get('ss_nama');

        $head->update($datainduk);

        Output::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

        return redirect()->route('detil_output', ['data'=>Session::get('ss_rbaid')]);
      } catch (\Exception $id) {
        return redirect()->route('detil_output', ['data'=>Session::get('ss_rbaid')]);
      }
    }

    public function download1()
    {
      $data = MasterRba::orderBy('no_rba', 'asc')->whereNotNull('unit_kerja');

      if (Session::get('ss_adm_unit') != 'fakultas') {
        $data = $data->where('unit_kerja', Session::get('ss_adm_unit'));
      }

      if (Session::get('ss_adm_tahun')) {
        $data = $data->where('tahun', Session::get('ss_adm_tahun'));
      }

      if (Session::get('ss_adm_filter') != null || Session::get('ss_adm_filter') != '') {
        $data = $data->WhereRaw("lower(sub_program) LIKE '%$filter%'");
      }
      $data = $data->get();

      $name = 'Realisasi ' . Session::get('ss_adm_unit');
      Excel::create($name, function ($excel) use ($data) {
            // Set the properties
        $name = Session::get('ss_adm_unit');
        $excel->setTitle($name)
          ->setCreator('Moneva FMIPA ' . date('Y'));
        $excel->sheet($name, function ($sheet) use ($data) {

          $sheet->setMergeColumn(array(
            'columns' => array('A', 'B', 'C', 'D', 'L'),
            'rows' => array(
              array(1, 2),
              array(1, 2),
              array(1, 2),
              array(1, 2),
              array(1, 2),
            ),
          ));

          $sheet->mergeCells('E1:G1');
          $sheet->mergeCells('H1:K1');

          $sheet->cell('A1', function ($cell) {
            $cell->setValue('No');
            $cell->setValignment('center');
            $cell->setalignment('center');
          });
          $sheet->cell('B1', function ($cell) {
            $cell->setValue('Unit');
            $cell->setValignment('center');
            $cell->setalignment('center');
          });
          $sheet->cell('C1', function ($cell) {
            $cell->setValue('No. RBA');
            $cell->setValignment('center');
            $cell->setalignment('center');
          });
          $sheet->cell('D1', function ($cell) {
            $cell->setValue('Nama Kegiatan');
            $cell->setValignment('center');
            $cell->setalignment('center');
          });
          $sheet->cell('L1', function ($cell) {
            $cell->setValue('Keterangan');
            $cell->setValignment('center');
            $cell->setalignment('center');
          });

          $sheet->cell('E1', function ($cell) {
            $cell->setValue('Anggaran');
            $cell->setValignment('center');
            $cell->setalignment('center');
          });
          $sheet->cell('H1', function ($cell) {
            $cell->setValue('Output');
            $cell->setValignment('center');
            $cell->setalignment('center');
          });
          $sheet->cell('E2', function ($cell) {
            $cell->setValue('Pagu');
            $cell->setValignment('center');
            $cell->setalignment('center');
          });
          $sheet->cell('F2', function ($cell) {
            $cell->setValue('Realisasi');
            $cell->setValignment('center');
            $cell->setalignment('center');
          });
          $sheet->cell('G2', function ($cell) {
            $cell->setValue('Persentase');
            $cell->setValignment('center');
            $cell->setalignment('center');
          });
          $sheet->cell('H2', function ($cell) {
            $cell->setValue('Target');
            $cell->setValignment('center');
            $cell->setalignment('center');
          });
          $sheet->cell('I2', function ($cell) {
            $cell->setValue('Satuan');
            $cell->setValignment('center');
            $cell->setalignment('center');
          });
          $sheet->cell('J2', function ($cell) {
            $cell->setValue('Realisasi');
            $cell->setValignment('center');
            $cell->setalignment('center');
          });
          $sheet->cell('K2', function ($cell) {
            $cell->setValue('Persentase');
            $cell->setValignment('center');
            $cell->setalignment('center');
          });

          $sheet->setWidth(array(
            'A' => 6,
            'B' => 20,
            'C' => 20,
            'D' => 40,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 12,
            'I' => 12,
            'J' => 12,
            'K' => 12,
            'L' => 30
          ));

          $row = 2;
          $no = 1;
          foreach ($data as $value) {
            $sheet->row(++$row, array(
              $no,
              $value->unit_kerja,
              $value->no_rba,
              $value->sub_program,
              $value->anggaran_pagu,
              $value->anggaran_terserap,
              $value->anggaran_persen,
              $value->target,
              $value->satuan,
              $value->realisasi,
              $value->total_progres,
              $value->keterangan,
            ));
            $no++;
          }
        });
      })->export('xls');
    }
}
