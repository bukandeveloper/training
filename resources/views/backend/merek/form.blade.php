@extends('backend/layout')

<!-- page title -->
@section('title', $data->page_title . ' | ' . env('APP_NAME',''))

@section('content')
<section class="content-header">
    <h1>{{ $page_title or '' }}</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.merek') }}">Admin</a></li>
        <li class="active">{{ $data->h1 or 'CREATED/UPDATE' }}</li>
    </ol>
</section>
<!-- Main content -->
<section id="main-content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ $data->h1 or 'CREATED/UPDATE' }}</h3>
                    <a class="btn btn-primary pull-right" href="{{ route('admin.merek') }}">back</a>
                </div>
                <div class="box-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    {{ Form::open(array('url' => url($data->form_action), 'method' => 'POST', 'files' => true, 'id' => 'member-form')) }}
                    {{ Form::hidden('id', $data->id, array('id' => 'id')) }}

                    <div id="form-nama" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>
                            <strong class="field-title">Merek</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{-- use this extra input to force chrome to turn autocomplete off --}}
                            {{ Form::text('nama', $data->nama, array('placeholder' => ' ', 'class' => 'form-control validate[required]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>


                    <div id="form-button" class="form-group no-border">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center" style="margin-top: 20px;">
                            <button type="submit" name="submit" id="send" class="btn btn-primary">{{ $data->button }}</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('body-class', 'custom-select')

@section('css-scripts')
@endsection

@section('js-scripts')
<script src="{{ asset('js/backend/merek/form.js') }}"></script>
@endsection