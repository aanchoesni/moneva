@extends('layouts.master')

@section('title')
  {{-- {{ $title }} --}}
@stop

@section('asset')
  <link rel="stylesheet" type="text/css" href="{!!asset('backend/assets/advanced-datatable/media/css/demo_page.css')!!}">
  <link rel="stylesheet" type="text/css" href="{!!asset('backend/assets/advanced-datatable/media/css/demo_table.css')!!}">
  {{-- <link rel="stylesheet" type="text/css" href="{!!asset('backend/assets/data-tables/DT_bootstrap.css')!!}"> --}}
  <link rel="stylesheet" type="text/css" href="{!!asset('backend/select2/select2-bootstrap.css')!!}">
  <link rel="stylesheet" type="text/css" href="{!!asset('backend/select2/packages/select2/select2.css')!!}">
@stop

@section('content')
<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Daftar
                @if(Session::get('ss_typeuser') == 'admin')
                  Admin
                @endif
                @if(Session::get('ss_typeuser') == 'prodi')
                  prodi
                @endif
            </header>
            <br><span style="padding-left: 15px"><a href="{{URL::to('user/create')}}" class="btn btn-info"><i class="fa fa-plus"></i> Tambah</a></span>
            <div class="panel-body">
                  <div class="adv-table">
                      <table  class="display table table-bordered table-striped" id="tbuser">
                        <thead>
                          <tr>
                            <th style="text-align:center;" width="5%">No</th>
                            <th style="text-align:center;" width="32%">Nama</th>
                            <th style="text-align:center;" width="20%">Email</th>
                            <th style="text-align:center;" width="20%">Prodi</th>
                            <th style="text-align:center;" width="13%">Menu</th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php $no = 1; ?>
                          @foreach($data as $value)
                            <tr>
                              <td style="text-align:center;"><?php echo $no++ ?></td>
                              <td>{!! $value->name !!}</td>
                              <td>{!! $value->email !!}</td>
                              <td>{!! $value->unit !!}</td>
                              <td style="text-align:center;">
                                <a href="{{ route('user.edit', ['data'=>Crypt::encrypt($value->id)]) }}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>
							                  <button class="btn btn-danger btn-xs" id="btn_delete" data-file="{{$value->id}}"><i class="fa fa-trash-o"></i></button>
                                {{ Form::open(['url'=>route('user.destroy', ['data'=>Crypt::encrypt($value->id)]), 'method'=>'delete', 'id' => $value->id, 'style' => 'display: none;']) }}
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
  <script type="text/javascript" src="{!!asset('backend/assets/advanced-datatable/media/js/jquery.js') !!}"></script>
  <script type="text/javascript" src="{!!asset('backend/assets/advanced-datatable/media/js/jquery.dataTables.js') !!}"></script>
  <script type="text/javascript" src="{!!asset('backend/assets/data-tables/DT_bootstrap.js') !!}"></script>
  <script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $('#tbuser').dataTable();
    } );
  </script>
  <script type="text/javascript" src="{!!asset('backend/select2/packages/select2/select2.min.js') !!}"></script>
  <script type="text/javascript" src="{!!asset('backend/select2/packages/select2/select2_locale_id.js') !!}"></script>
  <script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $("#is_active").select2({ width: '250px' });
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
