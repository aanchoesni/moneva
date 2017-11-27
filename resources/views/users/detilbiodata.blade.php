<div class="modal-body" id="inseojs">
  <div class="form-group">
    <div class="col-lg-12">
        <center>
          <img src="{{ url('/storage/'.$data->photo) }}" style="height:150px; width: auto; margin-bottom: 10px;">
          <img src="{{ url('/storage/'.$data->scn_ktp) }}" style="height:150px; width: auto; margin-bottom: 10px;">
        </center>
    </div>
  </div>
  <div class="form-group">
    {{ Form::label('nuid', 'Nomor ID', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    {{ Form::label('nuid', $data->numid, array('class' => 'control-label col-lg-8')) }}
  </div>
  <div class="form-group">
    {{ Form::label('nuid', 'Nomor Identitas', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    {{ Form::label('nuid', $data->noidentitas, array('class' => 'control-label col-lg-8')) }}
  </div>
  <div class="form-group">
    {{ Form::label('nuid', 'Nama', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    {{ Form::label('nuid', $data->akun->name, array('class' => 'control-label col-lg-8')) }}
  </div>
  <div class="form-group">
    {{ Form::label('nuid', 'TTL', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    {{ Form::label('nuid', $data->tmplahir.", ".InseoHelper::tglindo($data->tgllahir, 1), array('class' => 'control-label col-lg-8')) }}
  </div>
  <div class="form-group">
    {{ Form::label('nuid', 'Jenis Kelamin', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    {{ Form::label('nuid', $data->jeniskelamin, array('class' => 'control-label col-lg-8')) }}
  </div>
  <div class="form-group">
    {{ Form::label('nuid', 'Email', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    {{ Form::label('nuid', $data->akun->email, array('class' => 'control-label col-lg-8')) }}
  </div>
  <div class="form-group">
    {{ Form::label('nuid', 'Nomor HP', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    {{ Form::label('nuid', $data->nohp, array('class' => 'control-label col-lg-8')) }}
  </div>
  <div class="form-group">
    {{ Form::label('nuid', 'Nomor WA', array('class' => 'control-label col-lg-3')) }}
    {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
    {{ Form::label('nuid', $data->nowa, array('class' => 'control-label col-lg-8')) }}
  </div>
  <div class="form-group">
    @if ($data->akun->role == 'guru')
      {{ Form::label('nuid', 'Instansi', array('class' => 'control-label col-lg-3')) }}
      {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
      {{ Form::label('nuid', $data->instansi, array('class' => 'control-label col-lg-8')) }}
    @elseif ($data->akun->role == 'mahasiswa')
      {{ Form::label('nuid', 'Perguruan Tinggi', array('class' => 'control-label col-lg-3')) }}
      {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
      @if ($data->instansi)
      {{ Form::label('nuid', $data->universitas->universitas, array('class' => 'control-label col-lg-8')) }}
      @else
        {{ Form::label('nuid', '-', array('class' => 'control-label col-lg-8')) }}
      @endif
    @else
      {{ Form::label('nuid', 'Instansi', array('class' => 'control-label col-lg-3')) }}
      {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
      {{ Form::label('nuid', $data->instansi, array('class' => 'control-label col-lg-8')) }}
    @endif
  </div>
  <div class="form-group">
    @if ($data->akun->role == 'guru')
      {{ Form::label('nuid', 'Wilayah', array('class' => 'control-label col-lg-3')) }}
      {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
      @if ($data->alamat)
      {{ Form::label('nuid', $data->wilayah->nama, array('class' => 'control-label col-lg-8')) }}
      @else
        {{ Form::label('nuid', '-', array('class' => 'control-label col-lg-8')) }}
      @endif
    @elseif ($data->akun->role == 'mahasiswa')
      {{ Form::label('nuid', 'Prodi', array('class' => 'control-label col-lg-3')) }}
      {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
      {{ Form::label('nuid', $data->prodi->prodi, array('class' => 'control-label col-lg-8')) }}
    @else
      {{ Form::label('nuid', 'Wilayah', array('class' => 'control-label col-lg-3')) }}
      {{ Form::label('nuid', ':', array('class' => 'control-label col-lg-1')) }}
      @if ($data->alamat)
      {{ Form::label('nuid', $data->wilayah->nama, array('class' => 'control-label col-lg-8')) }}
      @else
        {{ Form::label('nuid', '-', array('class' => 'control-label col-lg-8')) }}
      @endif
    @endif
  </div>
</div>
