@extends('backend/layout')

<!-- page title -->
@section('title', $page_title . ' | ' . env('APP_NAME',''))

@section('content')
<section class="content-header">
    <h1>{{ $page_title or '' }}</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.admins.index') }}">Admin</a></li>
        <li class="active">{{ $h1 or 'CREATED/UPDATE' }}</li>
    </ol>
</section>
<!-- Main content -->
<section id="main-content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ $h1 or 'CREATED/UPDATE' }}</h3>
                    <a class="btn btn-primary pull-right" href="{{ route('admin.admins.index') }}">back</a>
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
                    {{ Form::open(array('url' => url($form_action), 'method' => 'POST', 'files' => false, 'id' => 'admin-form')) }}
                    {{ $page_type != 'edit' ? '' : method_field('PUT') }}
                    {{ Form::hidden('id', $item->id, array('id' => 'admin_id')) }}

                    <div id="form-email" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">必須</span>
                            <strong class="field-title">メールアドレス</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{-- use this extra input to force chrome to turn autocomplete off --}}
                            <input type="password" name="password" style="display:none">
                            {{ Form::text('email', $item->email, array('placeholder' => ' ', 'class' => 'form-control validate[required, custom[email]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>

                    {{--<div id="form-display_name" class="form-group">--}}
                        {{--<div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">--}}
                            {{--<span class="label label-danger label-required">必須</span>--}}
                            {{--<strong class="field-title">氏名</strong>--}}
                        {{--</div>--}}
                        {{--<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">--}}
                            {{--{{ Form::text('display_name', $item->display_name, array('placeholder' => '', 'class' => 'form-control validate[required, maxSize[100]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    @if ($page_type == "create")
                    <div id="form-password" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">必須</span>
                            <i class="fa fa-question-circle tooltip-img" data-toggle="tooltip" data-placement="right" title="パスワードは8文字以上で設定して下さい。"></i>
                            <strong class="field-title">パスワード</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::password('password', array('placeholder' => ' ', 'class' => 'form-control validate[required, minSize[6], maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                        </div>
                    </div>
                    {{-- case of update --}}
                    @else
                    <div id="form-password" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">必須</span>
                            <i class="fa fa-question-circle tooltip-img" data-toggle="tooltip" data-placement="right" title="パスワードを変更するときのみ入力して下さい。"></i>
                            <strong class="field-title">パスワード</strong>
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1 col-content">
                            <button type="button" name="reset" id="reset-button" class="btn btn-primary">変更</button>
                        </div>
                        <div id="reset-field" class="col-xs-10 col-sm-10 col-md-8 col-lg-9 col-content hide">
                            {{ Form::password('password', array('id' => 'password', 'placeholder' => 'パスワードを変更するときのみ入力して下さい', 'class' => 'form-control validate[minSize[8], maxSize[255]]', 'style' => 'margin-top:5px')) }}
                            <label for="show-password"><input id="show-password" type="checkbox" name="show-password" value="1"> パスワードを表示する</label>
                        </div>
                    </div>
                    @endif

                    <div id="form-button" class="form-group no-border">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center" style="margin-top: 20px;">
                            <button type="submit" name="submit" id="send" class="btn btn-primary">{{ $button_text }}</button>
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
<script src="{{ asset('js/backend/admins/form.js') }}"></script>
@endsection