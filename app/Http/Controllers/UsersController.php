<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Alert;
use Crypt;
use Session;
use App\Models\Unit;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::orderBy('name', 'asc')->get();

        return view('users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $prodi = Unit::orderBy('unit', 'asc')->pluck('unit', 'unit');

      return view('users.create', compact('prodi'))->withTitle('Tambah');
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
        $validator = Validator::make($data, User::$rules, User::$errormessage);

        if ($validator->fails()) {

            $errormessage = $validator->messages();
            return redirect()->route('user.create')
                ->withErrors($validator)
                ->withInput();

        } else {
            $data['password'] = bcrypt($request->input('password'));
            $data['is_active'] = 1;
            $data['userid_created'] = Session::get('ss_nama');
            $data['userid_updated'] = Session::get('ss_nama');

            User::create($data);

            Alert::success('Data berhasil disimpan')->persistent('Ok');

            $successmessage = "Proses Tambah User Berhasil !!";
            return redirect()->route('user.index')->with('successMessage', $successmessage);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find(Crypt::decrypt($id));
        $prodi = Unit::orderBy('unit', 'asc')->pluck('unit', 'unit');

        return view('users.edit', compact('user', 'prodi'))->withTitle('Ubah User');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idx)
    {
        $id = Crypt::decrypt($idx);
        $user = User::where('id', $id)->first();

        $rules = [
            'name' => 'required',
            'email' => 'required',
        ];

        $errormessage = [
            'required' => 'Form Input Ini Tidak Boleh Kosong / Harus Diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $errormessage);

        if ($validator->fails()) {

            $errormessage = $validator->messages();
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();

        }

        if($request->input('password') != null || $request->input('password') != ''){
            User::where('id', $id)->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'role' => $request->input('role'),
                'unit' => $request->input('unit'),
                'password' => bcrypt($request->input('password')),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            User::where('id', $id)->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'role' => $request->input('role'),
                'unit' => $request->input('unit'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        return redirect()->route('user.index')->with('successMessage', 'Berhasil mengubah user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      try {
        User::where('id', Crypt::decrypt($id))->delete(Crypt::decrypt($id));

        return redirect()->route('user.index')->with('successMessage', 'Berhasil menghapus user');
      } catch (\Exception $id) {
        return redirect()->route('user.index')->with('successMessage', 'Berhasil menghapus user');
      }
    }
}
