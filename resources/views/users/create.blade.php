@extends('layouts.master')

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
            	{{ Form::open(array('url' => route('user.store'), 'method' => 'post', 'id' => 'fmusers', 'class'=>'cmxform form-horizontal tasi-form')) }}
              <div class="form-group">
                {{ Form::label('name', 'Nama Lengkap', array('class' => 'control-label col-lg-2')) }}
                <div class="col-lg-10">
                  {{ Form::text('name', null, array('class' => 'form-control tkh','placeholder'=>'masukkan nama')) }}
                </div>
              </div>
              <div class="form-group">
                {{ Form::label('role', 'Role', array('class' => 'control-label col-lg-2')) }}
                <div class="col-lg-10">
                  {{ Form::select('role', ['admin'=>'Admin', 'jurusan'=>'Jurusan'], null, array('class' => 'form-control tkh')) }}
                </div>
              </div>
              <div class="form-group">
                {{ Form::label('unit', 'Unit', array('class' => 'control-label col-lg-2')) }}
                <div class="col-lg-10">
                  {{ Form::select('unit', $prodi, null, array('class' => 'form-control tkh')) }}
                </div>
              </div>
              <div class="form-group">
                {{ Form::label('email', 'Email', array('class' => 'control-label col-lg-2')) }}
                <div class="col-lg-10">
                  {{ Form::email('email', null, array('class' => 'form-control tkh','placeholder'=>'masukkan email')) }}
                </div>
              </div>
              <div class="form-group">
                {{ Form::label('password', 'Password', array('class' => 'control-label col-lg-2')) }}
                <div class="col-lg-10">
                  {{ Form::password('password', array('class' => 'form-control tkh','placeholder'=>'**********')) }}
                </div>
              </div>
              <div class="form-group">
                {{ Form::label('password-confirm', 'Confirm Password', array('class' => 'control-label col-lg-2')) }}
                <div class="col-lg-10">
                  {{ Form::password('password_confirmation', array('class' => 'form-control tkh','placeholder'=>'**********')) }}
                </div>
              </div>
              <div class="box-footer">
              {{Form::submit('Simpan', array('class'=>'btn btn-danger'))}}
              <a href="{{ URL::to('user') }}" class="btn btn-default" type="button">Batal</a>
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
