@extends('backend/layout')

<!-- page title -->
@section('title', 'produk-kategori | ' . env('APP_NAME',''))
@section('content')
    <section class="content-header">
        <h1>
            produk-kategori
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            {{-- <li><a href="#">produk-kategori</a></li> --}}
            <li class="active">produk-kategori</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">list</h3>
                        <a class="btn btn-primary pull-right" href="{{ route('admin.produk-kategori.add') }}">Create New</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        {{ Form::hidden('total-data', '', array('id'=>'total-data')) }}

                        <div id="datalist-header" class="pull-right invisible">Showing <span id="datalist-min-data"></span>〜<span id="datalist-max-data"></span> Of Total <span id="datalist-total-data"></span></div>
                        <div id="datalist"></div>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@section('title', 'produk-kategori List')

@section('css-scripts')
    <!-- Tabulator css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tabulator/3.3.3/css/tabulator.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tabulator/3.3.3/css/bootstrap/tabulator_bootstrap.min.css" rel="stylesheet">
@endsection

@section('js-scripts')
    <!-- Jquery UI -->
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Tabulator js -->
    <script src="{{ asset('js/3rdparty/tabulator.min.js') }}"></script>
    <script src="{{ asset('js/backend/produk-kategori/index.js') }}"></script>
@endsection
