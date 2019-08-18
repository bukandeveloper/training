@extends('backend/layout')
<!-- page title -->
@section('title', $page_title . ' | ' . env('APP_NAME',''))

@section('content')
<section class="content-header">
    <h1>
        Admin
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">admin</li>
    </ol>
</section>
<!-- Main content -->
<section class="content admins-content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                    <h3 class="box-title">List Admin</h3>
                    <a id="btn-add" class="btn btn-primary pull-right" href="{{ route('admin.admins.create') }}">Buat Admin Baru</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    {{-- show success message --}}
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                    {{-- show error message --}}
                    @if ($message = Session::get('error'))
                    <div class="alert alert-error">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                    {{-- used for pager calculation in js --}}
                    {{ Form::hidden('total-data', '', array('id'=>'total-data')) }}
                    <div id="datalist-header" class="pull-right invisible">Total Data : <span id="datalist-total-data"></span> Menampilkan table data ke<span id="datalist-min-data"></span>〜<span id="datalist-max-data"></span></div>
                    <div id="datalist"></div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
@endsection

@section('css-scripts')
<!-- Tabulator css -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/tabulator/3.3.3/css/tabulator.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/tabulator/3.3.3/css/bootstrap/tabulator_bootstrap.min.css" rel="stylesheet">
@endsection

@section('js-scripts')
<script src="{{ asset('js/backend/admins/index.js') }}"></script>
@endsection
