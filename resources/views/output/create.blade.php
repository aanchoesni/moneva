@extends('layouts.master')

@section('asset')
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
                Tambah Output
            </header>
            <div class="panel-body">
            	{{ Form::open(array('url' => route('output.store'), 'method' => 'post', 'id' => 'create_output', 'class'=>'cmxform form-horizontal tasi-form')) }}
              <div class="form-group">
                {{ Form::label('terserap', 'Dana yang terserap', array('class' => 'control-label col-lg-2')) }}
                <div class="col-lg-10">
                  {{ Form::text('terserap', null, array('class' => 'form-control tkh','placeholder'=>'Dana yang terserap')) }}
                </div>
              </div>
              <div class="form-group">
                {{ Form::label('realisasi', 'Realisasi', array('class' => 'control-label col-lg-2')) }}
                <div class="col-lg-10">
                  {{ Form::text('realisasi', null, array('class' => 'form-control tkh','placeholder'=>'Realisasi')) }}
                </div>
              </div>
              <div class="form-group">
                {{ Form::label('tgl_digunakan', 'Tanggal digunakan', array('class' => 'control-label col-lg-2')) }}
                <div class="col-lg-10">
                  {{ Form::text('tgl_digunakan', Date('d-m-Y'), array('class' => 'form-control tkh','placeholder'=>'Tanggal digunakan', 'data-mask'=>'99-99-9999')) }}
                </div>
              </div>
              <div class="form-group">
                {{ Form::label('keterangan', 'Keterangan', array('class' => 'control-label col-lg-2')) }}
                <div class="col-lg-10">
                  {{ Form::textarea('keterangan', null, array('class' => 'form-control tkh','placeholder'=>'Keterangan', 'style'=>'resize: none;', 'rows'=>'5')) }}
                </div>
              </div>
              <div class="box-footer">
              {{Form::submit('Simpan', array('class'=>'btn btn-danger'))}}
              <a href="{{ url('detil_output/'.Session::get('ss_rbaid')) }}" class="btn btn-default" type="button">Batal</a>
              </div>
            	{{ Form::close() }}
            </div>
        </section>
    </div>
</div>
@stop

@section('script')
  {{Html::script("backend/assets/advanced-datatable/media/js/jquery.js")}}
  {{Html::script("backend/js/jquery.validate.min.js")}}
  <!--script for this page-->
  {{Html::script("backend/js/form-validation-script.js")}}
  {{Html::script("backend/assets/bootstrap-inputmask/bootstrap-inputmask.min.js")}}
@stop
