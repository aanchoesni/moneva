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
                Monitoring
            </header>
            <div class="panel-body"  style:"overflow: scroll;">
              <div class="adv-table">
                  <table class="display table table-bordered table-striped" id="">
                    <thead>
                      <tr>
                        <th style="text-align:center;">No</th>
                        <th style="text-align:center;">Unit Kerja</th>
                        <th style="text-align:center;">Januari</th>
                        <th style="text-align:center;">Februari</th>
                        <th style="text-align:center;">Maret</th>
                        <th style="text-align:center;">April</th>
                        <th style="text-align:center;">Mei</th>
                        <th style="text-align:center;">Juni</th>
                        <th style="text-align:center;">Juli</th>
                        <th style="text-align:center;">Agustus</th>
                        <th style="text-align:center;">September</th>
                        <th style="text-align:center;">Oktober</th>
                        <th style="text-align:center;">November</th>
                        <th style="text-align:center;">Desember</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php $no = 1; ?>
                      @foreach($vardat as $key => $value)
                        <tr>
                          <td style="text-align:center;"><?php echo $no++ ?></td>
                          <td>
                            <div style="color: black; font-weight: bold;">{!! $key !!}</div>
                          </td>
                          {{--  @for ($i=1; $i <= 12; $i++)

                          @endfor  --}}
                          @foreach($value as $v)
                            <td style="text-align: center;">
                              <div>
                              @if($v == 0)
                                <i class="fa fa-times" style="color: red"></i>
                              @endif
                              @if($v == 1)
                                <i class="fa fa-check" style="color: green"></i>
                              @endif
                              </div>
                            </td>
                          @endforeach
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
