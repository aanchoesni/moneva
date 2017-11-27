<li>
    <a href="{!! url('/') !!}">
        <i class="fa fa-dashboard"></i>
        <span>Dashboard</span>
    </a>
</li>
@if (Session::get('ss_role') == 'admin')
<li>
    <a href="{!! url('user') !!}">
        <i class="fa fa-user"></i>
        <span>User</span>
    </a>
</li>
<li>
    <a href="{!! url('master_rba') !!}">
        <i class="fa fa-dollar"></i>
        <span>RBA</span>
    </a>
</li>
<li>
    <a href="{!! url('monitoring') !!}">
        <i class="fa fa-desktop"></i>
        <span>Monitoring</span>
    </a>
</li>
<li>
    <a href="{!! url('output') !!}">
        <i class="fa fa-tasks"></i>
        <span>Realisasi</span>
    </a>
</li>
@endif
@if (Session::get('role') == 'jurusan')
<li>
    <a href="{!! url('jurusan') !!}">
        <i class="fa fa-tasks"></i>
        <span>Realisasi</span>
    </a>
</li>
@endif
{{-- <li><a href="{{ url('admin/settings') }}"><i class="fa fa-gears"></i> Setting</a></li> --}}
