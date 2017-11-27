@extends('layouts.masteradmin')

@section('asset')
  <link rel="stylesheet" type="text/css" href="{!!asset('backend/assets/bootstrap-datepicker/css/datepicker.css')!!}">
  <link rel="stylesheet" type="text/css" href="{!!asset('backend/assets/bootstrap-timepicker/compiled/timepicker.css')!!}">
  <link rel="stylesheet" type="text/css" href="{!!asset('backend/assets/bootstrap-datetimepicker/css/datetimepicker.css')!!}">
  <style>
    .tkh {
        color: black;
    }
	</style>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                User Baru ({!! Session::get('ss_typeuser') !!})
            </header>
            <div class="panel-body">
            	{{ Form::open(array('url' => route('users.uploadexcel'), 'method' => 'post', 'id' => 'uploadexcel', 'class'=>'cmxform form-horizontal tasi-form', 'files' => 'true')) }}
              <div class="form-group">
                  {{ Form::label('file', 'Unggah user', array('class' => 'control-label col-lg-2') ) }}
                  <div class="col-lg-10">
                      {{ Form::file('excel', ['onchange'=>'ValidateSingleInput(this); checkFileSize(this);', 'required']) }}
                      <p class="help-block">Upload excel.</p>
                  </div>
              </div>
              <div class="box-footer">
              {{Form::submit('Simpan', array('class'=>'btn btn-danger'))}}
              @if(Session::get('ss_typeuser') == 'admin')
              <a href="{{ URL::to('useradmin') }}" class="btn btn-default" type="button">Batal</a>
              @endif
              @if(Session::get('ss_typeuser') == 'peneliti')
              <a href="{{ URL::to('userpeneliti') }}" class="btn btn-default" type="button">Batal</a>
              @endif
              @if(Session::get('ss_typeuser') == 'guru')
              <a href="{{ URL::to('userguru') }}" class="btn btn-default" type="button">Batal</a>
              @endif
              @if(Session::get('ss_typeuser') == 'mahasiswa')
              <a href="{{ URL::to('usermahasiswa') }}" class="btn btn-default" type="button">Batal</a>
              @endif
              @if(Session::get('ss_typeuser') == 'user')
              <a href="{{ URL::to('userumum') }}" class="btn btn-default" type="button">Batal</a>
              @endif
              </div>
            	{{ Form::close() }}
            </div>
        </section>
    </div>
</div>
@stop

@section('script')
	<script type="text/javascript" src="{!!asset('backend/assets/advanced-datatable/media/js/jquery.js') !!}"></script>
	<script type="text/javascript" src="{!!asset('backend/js/jquery.validate.min.js') !!}"></script>
  <!--script for this page-->
  <script type="text/javascript" src="{!!asset('backend/js/form-validation-script.js') !!}"></script>
  <script type="text/javascript" src="{!!asset('backend/assets/bootstrap-datepicker/js/bootstrap-datepicker.js') !!}"></script>
  <script type="text/javascript" src="{!!asset('backend/js/advanced-form-components.js') !!}"></script>
  <script type="text/javascript" src="{!!asset('backend/assets/bootstrap-inputmask/bootstrap-inputmask.min.js') !!}"></script>
@stop

@section('scriptbottom')
  <script>
  var pdf=false;

  function getFileExtension(filename){
  var ext = /^.+\.([^.]+)$/.exec(filename);
  return ext == null ? "" : ext[1];
  }
  function ValidateSingleInput(oInput) {
  var _validFileExtensions = [".xls", ".xlsx"];
    if (oInput.type == "file") {
        var sFileName = oInput.value;
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    pdf=true;
                    break;
                }
            }

            if (!blnValid) {
                swal("Oops...", "File yang diupload harus excel", "error");
                oInput.value = "";
                pdf=false;
                return false;
            }
        }
    }
    return true;
  }

  function checkFileSize(inputFile) {
  var max =  1024000; // 1MB

  if (inputFile.files && inputFile.files[0].size > max) {
    swal("Oops...", "File terlalu besar (lebih dari 1MB) ! Mohon kompres/perkecil ukuran file", "error");
    inputFile.value = null; // Clear the field.
   }
  }
  </script>
@stop
