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
                Ubah Output
            </header>
            <div class="panel-body">
            {!! Form::model($output, ['route' => ['output.update', $output->id], 'method'=>'patch', 'class'=>'cmxform form-horizontal tasi-form', 'id'=>'output']) !!}
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
                {{ Form::text('tgl_digunakan', date('d-m-Y', strtotime($output['tgl_digunakan'])), array('class' => 'form-control tkh','placeholder'=>'Tanggal digunakan', 'data-mask'=>'99-99-9999')) }}
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
        	  {!! Form::close() !!}
        	</div>
        </section>
    </div>
</div>
@stop

@section('script')
	<script type="text/javascript" src="https://statik.unesa.ac.id/tesline_konten_statik/backend/assets/advanced-datatable/media/js/jquery.js"></script>
	<script type="text/javascript" src="https://statik.unesa.ac.id/tesline_konten_statik/backend/js/jquery.validate.min.js"></script>
  <!--script for this page-->
  <script type="text/javascript" src="https://statik.unesa.ac.id/tesline_konten_statik/backend/js/form-validation-script.js"></script>
@stop
