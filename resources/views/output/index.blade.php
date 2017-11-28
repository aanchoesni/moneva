@extends('layouts.master')

@section('asset')
  <link rel="stylesheet" type="text/css" href="https://statik.unesa.ac.id/survey_konten_statik/backend/assets/advanced-datatable/media/css/demo_page.css">
  <link rel="stylesheet" type="text/css" href="https://statik.unesa.ac.id/survey_konten_statik/backend/assets/advanced-datatable/media/css/demo_table.css">
  {{-- <link rel="stylesheet" type="text/css" href="backend/assets/data-tables/DT_bootstrap.css')!!} --}}
  <style>
    .tkh {
        color: black;
    }
	</style>
@stop

@section('content')
<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Realisasi
            </header>
            <div class="form-inline">
              <div class="form-group">
                {{ Form::open(array('url' => route('output.index'), 'method' => 'get', 'style'=>'padding-left: 15px; padding-top: 15px;')) }}
                {{ Form::select('tahun', $tahun, Session::get('ss_adm_tahun'), array('id'=>'tahun', 'style'=>'width: 150px', 'placeholder' => '- Tahun -', 'class'=>'form-control input-sm tkh', "onChange"=>"this.form.submit();")) }}
                {{ Form::text('unit', Session::get('ss_adm_unit'), ['style'=>'display: none;']) }}
                {{ Form::text('filter', Session::get('ss_adm_filter'), ['style'=>'display: none;']) }}
                {{ Form::close() }}
              </div>
              <div class="form-group">
                {{ Form::open(array('url' => route('output.index'), 'method' => 'get', 'style'=>'padding-left: 15px; padding-top: 15px;')) }}
                {{ Form::text('tahun', Session::get('ss_adm_tahun'), ['style'=>'display: none;']) }}
                {{ Form::select('unit', $unit, Session::get('ss_adm_unit'), array('id'=>'unit', 'style'=>'width: 150px', 'placeholder' => '- Unit Kerja -', 'class'=>'form-control input-sm tkh', "onChange"=>"this.form.submit();")) }}
                {{ Form::text('filter', Session::get('ss_adm_filter'), ['style'=>'display: none;']) }}
                {{ Form::close() }}
              </div>
              <div class="form-group">
                {{ Form::open(array('url' => route('output.index'), 'method' => 'get', 'style'=>'padding-left: 15px; padding-top: 15px;')) }}
                {{ Form::text('tahun', Session::get('ss_adm_tahun'), ['style'=>'display: none;']) }}
                {{ Form::text('unit', Session::get('ss_adm_unit'), ['style'=>'display: none;']) }}
                {{ Form::text('filter', Session::get('ss_adm_filter'), ['class'=>'form-control tkh', 'placeholder'=>'Filter']) }}
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>Filter</button>
                {{ Form::close() }}
              </div>
              @if (Session::get('ss_role') == 'admin')
              <div class="form-group">
                {{ Form::open(array('url' => route('output.index'), 'method' => 'get', 'style'=>'padding-left: 15px; padding-top: 15px;')) }}
                <button type="submit" class="btn btn-danger"><i class="fa fa-clear"></i>Clear</button>
                {{ Form::close() }}
              </div>
              @endif
              @if (Session::get('ss_role') == 'jurusan')
              <div class="form-group">
                {{ Form::open(array('url' => route('jurusan'), 'method' => 'get', 'style'=>'padding-left: 15px; padding-top: 15px;')) }}
                <button type="submit" class="btn btn-danger"><i class="fa fa-clear"></i>Clear</button>
                {{ Form::close() }}
              </div>
              @endif
              @if (Session::get('ss_adm_tahun'))
              <div class="form-group">
                {{ Form::open(array('url' => route('download1'), 'method' => 'get', 'style'=>'padding-left: 15px; padding-top: 15px;')) }}
                <button type="submit" class="btn btn-success"><i class="fa fa-download"></i> Download</button>
                {{ Form::close() }}
              </div>
              @endif
            </div>
            <div class="panel-body"  style:"overflow: scroll;">
              <div class="adv-table">
                  <table class="display table table-bordered table-striped" id="">
                    <thead>
                      <tr>
                        <th style="text-align:center; vertical-align: middle;" rowspan="2">No</th>
                        <th style="text-align:center; vertical-align: middle;" rowspan="2">Nama Kegiatan</th>
                        <th style="text-align:center;" colspan="3">Anggaran</th>
                        <th style="text-align:center;" colspan="3">Output</th>
                        <th style="text-align:center; vertical-align: middle;" rowspan="2">Keterangan</th>
                        <th style="text-align:center; vertical-align: middle;" rowspan="2">Menu</th>
                      </tr>
                      <tr>
                        <th style="text-align:center;">Pagu</th>
                        <th style="text-align:center;">Realisasi</th>
                        <th style="text-align:center;">Persentase</th>
                        <th style="text-align:center;">Target</th>
                        <th style="text-align:center;">Realisasi</th>
                        <th style="text-align:center;">Total Progres</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php $no = 1; ?>
                      @foreach($data as $value)
                        <tr>
                          <td style="text-align:center;"><?php echo $no++ ?></td>
                          <td>
                            <div style="color: red;">{!! $value->no_rba !!}</div>
                            {!! $value->sub_program !!}
                            <div style="color: green;">({!! strtoupper($value->unit_kerja) !!})</div>
                          </td>
                          <td>Rp {!! number_format($value->anggaran_pagu, 0) !!}</td>
                          <td>Rp {!! number_format($value->anggaran_terserap, 0) !!}</td>
                          <td style="text-align: center;">{!! number_format($value->anggaran_persen, 0) !!}%</td>
                          <td style="text-align: center;">{!! $value->target !!}<div style="color: red;">{!! $value->satuan !!}</div></td>
                          <td style="text-align: center;">{!! $value->realisasi !!}</td>
                          <td style="text-align: center;">{!! number_format($value->total_progres, 0) !!}%</td>
                          <td>{!! $value->keterangan !!}</td>
                          <td style="text-align: center;">
                            <a href="{!! url('detil_output/'.$value->id) !!}" class="btn btn-warning btn-xs"><i class="fa fa-tasks"></i></a>
                          </td>
                          {{-- <td style="text-align:center;">
                            @if($value->is_active == 0)
                              <button class="btn btn-success btn-xs" id="btn_aktif" data-file="{{$value->id}}"><i class="fa fa-check"></i></button>
                              {{ Form::open(['url'=>route('responden_aktif', ['data'=>Crypt::encrypt($value->id)]), 'method'=>'get', 'id' => 'aktif_'.$value->id, 'style' => 'display: none;']) }}
                              {{ csrf_field() }}
                              {{ Form::close() }}
                            @endif
                            @if($value->is_active == 1)
                              <button class="btn btn-danger btn-xs" id="btn_naktif" data-file="{{$value->id}}"><i class="fa fa-times"></i></button>
                              {{ Form::open(['url'=>route('responden_naktif', ['data'=>Crypt::encrypt($value->id)]), 'method'=>'get', 'id' => 'non_aktif_'.$value->id, 'style' => 'display: none;']) }}
                              {{ csrf_field() }}
                              {{ Form::close() }}
                            @endif

                            <a href="{{ route('responden.edit', ['data'=>Crypt::encrypt($value->id)]) }}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>

                            <button class="btn btn-danger btn-xs" id="btn_delete" data-file="{{$value->id}}"><i class="fa fa-trash-o"></i></button>
                            {{ Form::open(['url'=>route('responden.destroy', ['data'=>Crypt::encrypt($value->id)]), 'method'=>'delete', 'id' => $value->id, 'style' => 'display: none;']) }}
                            {{ csrf_field() }}
                            {{ Form::close() }}
                          </td> --}}
                        </tr>
                        @endforeach
                      </tbody>
                  </table>
              </div>
            </div>
        </section>
    </div>
</div>
<!-- page end-->

<div class="modal fade" id="importexcel" tabindex="-1" role="dialog" aria-labelledby="importexcel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <center><h4 class="modal-title">Import Excel</h4></center>
          </div>
          <div class="modal-body">
            {{ Form::open(array('url' => route('uploadexcel'), 'method' => 'post', 'id' => 'uploadexcel', 'class'=>'cmxform form-horizontal tasi-form', 'files' => 'true')) }}
              <div class="form-group">
                  {{ Form::label('file', 'Import Excel RBA', array('class' => 'control-label col-lg-2') ) }}
                  <div class="col-lg-10">
                      {{ Form::file('excel', ['onchange'=>'ValidateSingleInput(this); checkFileSize(this);', 'required']) }}
                      <p class="help-block">Upload excel.</p>
                  </div>
              </div>
              <div class="box-footer">
              {{Form::submit('Simpan', array('class'=>'btn btn-danger'))}}
              </div>
            {{ Form::close() }}
          </div>
      </div>
    </div>
</div>
@stop

@section('script')
  {{Html::script("backend/assets/advanced-datatable/media/js/jquery.js")}}
  {{Html::script("backend/assets/advanced-datatable/media/js/jquery.dataTables.js")}}
  {{Html::script("backend/assets/data-tables/DT_bootstrap.js")}}
  <script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $('#tbl_settings').dataTable();
    } );

    $('button#btn_delete').on('click', function(e){
                e.preventDefault();
                var data = $(this).attr('data-file');

                swal({
                  title             : "Apakah Anda Yakin?",
                  text              : "Anda akan menghapus data ini!",
                  type              : "warning",
                  showCancelButton  : true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText : "Yes",
                  cancelButtonText  : "No",
                  closeOnConfirm    : false,
                  closeOnCancel     : false
                },
          function(isConfirm){
            if(isConfirm){
              swal("Terhapus","Data berhasil dihapus", "success");
              setTimeout(function() {
                $("#"+data).submit();
              }, 1000); // 1 second delay
            }
            else{
              swal("Dibatalkan","Data batal dihapus", "error");
            }
          }
    );});

    $('button#btn_aktif').on('click', function(e){
                e.preventDefault();
                var data = $(this).attr('data-file');

                swal({
                  title             : "Apakah Anda yakin?",
                  text              : "Responden ini dipakai!",
                  type              : "warning",
                  showCancelButton  : true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText : "Yes",
                  cancelButtonText  : "No",
                  closeOnConfirm    : false,
                  closeOnCancel     : false
                },
          function(isConfirm){
            if(isConfirm){
              swal("Dipakai","Responden dipakai", "success");
              setTimeout(function() {
                $("#aktif_"+data).submit();
              }, 1000); // 1 second delay
            }
            else{
              swal("cancelled","Dibatalkan", "error");
            }
          }
    );});

    $('button#btn_naktif').on('click', function(e){
                e.preventDefault();
                var data = $(this).attr('data-file');

                swal({
                  title             : "Apakah Anda yakin?",
                  text              : "Responden ini tidak dipakai!",
                  type              : "warning",
                  showCancelButton  : true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText : "Yes",
                  cancelButtonText  : "No",
                  closeOnConfirm    : false,
                  closeOnCancel     : false
                },
          function(isConfirm){
            if(isConfirm){
              swal("Dipakai","Responden tidak dipakai", "success");
              setTimeout(function() {
                $("#non_aktif_"+data).submit();
              }, 1000); // 1 second delay
            }
            else{
              swal("cancelled","Dibatalkan", "error");
            }
          }
    );});
  </script>
@stop
