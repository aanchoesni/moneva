<?php

namespace App\Http\Controllers;

use App\Models\MasterRba;
use Illuminate\Http\Request;
use Validator;
use Uuid;
use Alert;
use Session;
use Excel;
use DB;
use App\Helpers\InseoHelper;

class MasterRbaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function uploadexcel(Request $request)
    {
        try {
           Excel::load($request->file('excel'), function ($reader) {
               foreach ($reader->toObject() as $row) {
                   $uuid = Uuid::generate();
                   DB::table('master_rba')->insert([
                       'id' => $uuid,
                       'unit_kerja' => $row->unit_kerja,
                       'no_rba_induk' => $row->no_rba_induk,
                       'no_rba' => $row->no_rba,
                       'program' => $row->program_kegiatan,
                       'sub_program' => $row->sub_program,
                       'anggaran_pagu' => $row->pagu,
                    //    'anggaran_terserap' => $row->realisasi,
                       'target' => $row->jml_output,
                       'satuan' => $row->satuan,
                    //    'realisasi' => $row->realisasi,
                    //    'total_progres' => $row->persentase,
                       'jadwal_pelaksanaan' => $row->jadwal_pelaksanaan,
                       'tahun' => $row->tahun,
                       'userid_created' => Session::get('ss_nama'),
                       'userid_updated' => Session::get('ss_nama'),
                       'created_at' => date('Y-m-d H:i:s'),
                       'updated_at' => date('Y-m-d H:i:s'),
                   ]);
               }
           });

           Alert::success('Berhasi Menyimpan Data')->persistent('Ok');

           return redirect()->route('master_rba.index');
        } catch (\Exception $e) {
           Session::flash('message', $e->getMessage());
           $validator = $e->getMessage();

           // Alert::error('Error', $e->getMessage())->persistent('Ok');
           return redirect()->route('master_rba.index')->withErrors($validator);
        }
    }
    public function index()
    {
        // $child = MasterRba::orderBy('program', 'asc')->whereNotNull('unit_kerja')->get();
        $data = MasterRba::whereNull('no_rba_induk')->get();
        // $data = MasterRba::orderBy('program', 'asc')->get();

        return view('masterrba.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masterrba.create');
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
      $validator = Validator::make($data, MasterRba::$rules, MasterRba::$errormessage);

      if ($validator->fails()) {
          $errormessage = $validator->messages();
          return redirect()->back()->withErrors($validator)->withInput();
      }

      $uuid = Uuid::generate();

      $data['id'] = $uuid;
      $data['userid'] = Session::get('ss_iduser');
      $data['userid_created'] = Session::get('ss_nama');
      $data['userid_updated'] = Session::get('ss_nama');
      MasterRba::create($data);

      Alert::success('Successfully save data')->persistent('Ok');

      return redirect()->route('masterrba.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterRba  $masterRba
     * @return \Illuminate\Http\Response
     */
    public function show(MasterRba $masterRba)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterRba  $masterRba
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      try {
          $masterrba = MasterRba::find(Crypt::decrypt($id));

          return View('masterrba.edit', compact('masterrba'));
      } catch (\Exception $id) {
          return redirect('masterrba');
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterRba  $masterRba
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $responden = MasterRba::findOrFail($id);

      $data = $request->except('_token');
      $validator = Validator::make($data, MasterRba::$rules, MasterRba::$errormessage);

      if ($validator->fails()) {
          $errormessage = $validator->messages();
          return redirect()->back()->withErrors($validator)->withInput();
      }

      $data['userid_updated'] = Session::get('ss_nama');
      $responden->update($data);

      Alert::success('Successfully Update Data')->persistent('Ok');
      return redirect()->route('masterrba.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterRba  $masterRba
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      try {
          MasterRba::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

          return redirect()->route('masterrba.index');
      } catch (\Exception $id) {
          return redirect('masterrba');
      }
    }

    public function downloadrba()
    {
      $data = MasterRba::whereNull('no_rba_induk')->get();

      $name = 'RBA ' . $data[0]->tahun;
      Excel::create($name, function ($excel) use ($data) {
              // Set the properties
        $name = 'RBA ' . $data[0]->tahun;
        $excel->setTitle($name)
          ->setCreator('Moneva FMIPA ' . date('Y'));
        $excel->sheet($name, function ($sheet) use ($data) {

          $sheet->setMergeColumn(array(
            'columns' => array('A', 'B', 'C', 'D', 'K'),
            'rows' => array(
              array(1, 2),
              array(1, 2),
              array(1, 2),
              array(1, 2),
              array(1, 2),
            ),
          ));

          $sheet->mergeCells('E1:G1');
          $sheet->mergeCells('H1:J1');

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
          $sheet->cell('K1', function ($cell) {
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
            $cell->setValue('Realisasi');
            $cell->setValignment('center');
            $cell->setalignment('center');
          });
          $sheet->cell('J2', function ($cell) {
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
            'K' => 30
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
              $value->realisasi,
              $value->total_progres,
              $value->keterangan,
            ));
            $no++;

            $noc = 1;
            foreach (InseoHelper::child($value->no_rba) as $v) {
              $sheet->row(++$row, array(
                $noc,
                $v->unit_kerja,
                $v->no_rba,
                $v->sub_program,
                $v->anggaran_pagu,
                $v->anggaran_terserap,
                $v->anggaran_persen,
                $v->target,
                $v->realisasi,
                $v->total_progres,
                $v->keterangan,
              ));
              $noc++;
            }
          }
        });
      })->export('xls');
    }
}
