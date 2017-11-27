@extends('layouts.master')

@section('asset')
  <link rel="stylesheet" type="text/css" href="https://statik.unesa.ac.id/survey_konten_statik/backend/assets/advanced-datatable/media/css/demo_page.css">
  <link rel="stylesheet" type="text/css" href="https://statik.unesa.ac.id/survey_konten_statik/backend/assets/advanced-datatable/media/css/demo_table.css">
  {{-- <link rel="stylesheet" type="text/css" href="backend/assets/data-tables/DT_bootstrap.css')!!} --}}
  <style>
    .tkh {
        color: black;
    }
    .cred {
      color: red;
    }
    .cgreen {
      color: green;
    }
    .fwb {
      font-weight: bold;
    }
	</style>
@stop

@section('content')
<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
              Output RBA
            </header>
            <div>&nbsp;</div>
            <div class="col-lg-2">NO RBA </div> <div class="col-lg-10 cred fwb">{!! $induk->no_rba !!}</div>
            <div class="col-lg-2">Kegiatan </div> <div class="col-lg-10 fwb">{!! $induk->program !!}</div>
            <div class="col-lg-2">Sub Kegiatan </div> <div class="col-lg-10 fwb">{!! $induk->sub_program !!}</div>
            <div class="col-lg-2">Pagu </div> <div class="col-lg-10 fwb">Rp {!! number_format($induk->anggaran_pagu, 0) !!}</div>
            <div class="col-lg-2">Digunakan </div> <div class="col-lg-10 fwb">Rp {!! number_format($induk->anggaran_terserap, 0) !!}</div>
            <div class="col-lg-2">Target </div> <div class="col-lg-10 fwb">{!! $induk->target !!}</div>
            <div class="col-lg-2">Prodi </div> <div class="col-lg-10 cgreen fwb">{!! $induk->unit_kerja !!}</div>
            <div>&nbsp;</div>
            <span style="padding-left: 15px"><a href="{{URL::to('output/create')}}" class="btn btn-info"><i class="fa fa-plus"></i> Tambah</a></span>
            @if (Session::get('ss_role') == 'admin')
            <a href="{{ url('output') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali</a>
            @endif
            @if (Session::get('ss_role') == 'jurusan')
            <a href="{{ url('jurusan') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali</a>
            @endif
            <div class="panel-body" style:"overflow: auto;">
              <div class="adv-table">
                  <table class="display table table-bordered table-striped" id="tbl_detil">
                    <thead>
                      <tr>
                        <th style="text-align:center;">No</th>
                        <th style="text-align:center;">Keterangan</th>
                        <th style="text-align:center;">Realisasi</th>
                        <th style="text-align:center;">Dana Terserap</th>
                        <th style="text-align:center;">Tgl Digunakan</th>
                        <th style="text-align:center;">Menu</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php $no = 1; ?>
                      @foreach($data as $value)
                        <tr>
                          <td style="text-align:center;"><?php echo $no++ ?></td>
                          <td>{!! $value->keterangan !!}</td>
                          <td>{!! $value->realisasi !!}</td>
                          <td>{!! number_format($value->terserap, 0) !!}</td>
                          <td style="text-align: center;">{!! date('d-m-Y', strtotime($value->tgl_digunakan)) !!}</td>
                          <td style="text-align: center;">
                            <a href="{!! route('output.edit', ['data'=>Crypt::encrypt($value->id)]) !!}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>

                            <button class="btn btn-danger btn-xs" id="btn_delete" data-file="{{$value->id}}"><i class="fa fa-trash-o"></i></button>
                            {{ Form::open(['url'=>route('output.destroy', ['data'=>Crypt::encrypt($value->id)]), 'method'=>'delete', 'id' => $value->id, 'style' => 'display: none;']) }}
                            {{ csrf_field() }}
                            {{ Form::close() }}
                          </td>
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
@stop

@section('script')
  {{Html::script("backend/assets/advanced-datatable/media/js/jquery.js")}}
  {{Html::script("backend/assets/advanced-datatable/media/js/jquery.dataTables.js")}}
  {{Html::script("backend/assets/data-tables/DT_bootstrap.js")}}
  <script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $('#tbl_detil').dataTable();
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
  </script>
@stop
