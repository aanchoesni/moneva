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
        $data = MasterRba::orderBy('program', 'asc')->whereNotNull('unit_kerja')->get();

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
}
