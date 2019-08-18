@extends('backend/layout')

<!-- page title -->
@section('title', 'Login history admin | ' . env('APP_NAME',''))
@section('content')
    <section class="content-header">
        <h1>
            Login history admin
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"> Login history admin</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    {{-- To achieve the same format as other page, need to explicitly set height of box-header to the max of button --}}
                    {{-- Otherwise the tabular will not be displayed properly --}}
                    <div class="box-header" style="height: 84px;">
                        <h3 class="box-title">List Login history admin</h3>
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
                        <div id="datalist-header" class="pull-right invisible"><span id="datalist-total-data"></span>Total Data <span id="datalist-min-data"></span>〜<span id="datalist-max-data"></span>Page</div>
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
    <!-- Jquery UI -->
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Tabulator js -->
    <script src="{{ asset('js/3rdparty/tabulator.min.js') }}"></script>
    <script src="{{ asset('js/backend/login_histories/admin.js') }}"></script>
@endsection
