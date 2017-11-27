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
                Master RBA
            </header>
            {{--  <br><span style="padding-left: 15px"><a href="{{URL::to('master_rba/create')}}" class="btn btn-info"><i class="fa fa-plus"></i> Tambah</a></span>  --}}
            <br><span style="padding-left: 15px"><a href="#importexcel" data-toggle="modal" data-target="#importexcel" class="modalLink btn btn-success"><i class="fa fa-upload"></i> Import Excel</a></span>
            <a href="{!! url('downloadrba') !!}" class="btn btn-info"><i class="fa fa-download"></i> Eksport Excel</a>
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
                            @if($value->sub_program == null)
                            {!! $value->program !!}
                            @endif
                            @if($value->sub_program != null)
                            {!! $value->sub_program !!}
                            <div style="color: green;">({!! strtoupper($value->unit_kerja) !!})</div>
                            @endif
                          </td>
                          <td>Rp {!! number_format($value->anggaran_pagu, 0) !!}</td>
                          <td>Rp {!! number_format($value->anggaran_terserap, 0) !!}</td>
                          <td style="text-align: center;">{!! number_format($value->anggaran_persen, 0) !!}%</td>
                          <td style="text-align: center;">{!! $value->target !!}</td>
                          <td style="text-align: center;">{!! $value->realisasi !!}</td>
                          <td style="text-align: center;">{!! number_format($value->total_progres, 0) !!}%</td>
                          <td>{!! $value->keterangan !!}</td>
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
                          <?php $noc = 1; ?>
                          @foreach (InseoHelper::child($value->no_rba) as $v)
                          <tr>
                            <td></td>
                            <td>
                              <table>
                                <tr>
                                  <td style="text-align:center;"><?php echo $noc++ ?></td>
                                  <td>
                                    <div style="color: red;">{!! $v->no_rba !!}</div>
                                    @if($v->sub_program == null)
                                    {!! $v->program !!}
                                    @endif
                                    @if($v->sub_program != null)
                                    {!! $v->sub_program !!}
                                    <div style="color: green;">({!! strtoupper($v->unit_kerja) !!})</div>
                                    @endif
                                  </td>
                                </tr>
                              </table>
                            </td>
                            <td>Rp {!! number_format($v->anggaran_pagu, 0) !!}</td>
                            <td>Rp {!! number_format($v->anggaran_terserap, 0) !!}</td>
                            <td style="text-align: center;">{!! number_format($v->anggaran_persen, 0) !!}%</td>
                            <td style="text-align: center;">{!! $v->target !!}<div style="color: red;">{!! $v->satuan !!}</div></td>
                            <td style="text-align: center;">{!! $v->realisasi !!}</td>
                            <td style="text-align: center;">{!! number_format($v->total_progres, 0) !!}%</td>
                            <td>{!! $v->keterangan !!}</td>
                          </tr>
                          @endforeach
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
