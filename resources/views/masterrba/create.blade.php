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
                Tambah Kategori
            </header>
            <div class="panel-body">
            	{{ Form::open(array('url' => route('master_rba.store'), 'method' => 'post', 'id' => 'categories', 'class'=>'cmxform form-horizontal tasi-form')) }}
              <div class="form-group">
                {{ Form::label('kode', 'Kode Kategori', array('class' => 'control-label col-lg-2')) }}
                <div class="col-lg-1">
                  {{ Form::text('kode', null, array('class' => 'form-control tkh','placeholder'=>'Kode Kategori')) }}
                </div>
              </div>
              <div class="form-group">
                {{ Form::label('name', 'Nama Kategori', array('class' => 'control-label col-lg-2')) }}
                <div class="col-lg-10">
                  {{ Form::text('name', null, array('class' => 'form-control tkh','placeholder'=>'Nama Kategori')) }}
                </div>
              </div>
              <div class="form-group">
                {{ Form::label('desc', 'Deskripsi', array('class' => 'control-label col-lg-2')) }}
                <div class="col-lg-10">
                  {{ Form::text('desc', null, array('class' => 'form-control tkh','placeholder'=>'Deskripsi')) }}
                </div>
              </div>
              <div class="box-footer">
              {{Form::submit('Simpan', array('class'=>'btn btn-danger'))}}
              <a href="{{ URL::route('master_rba.index') }}" class="btn btn-default" type="button">Batal</a>
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
@stop
