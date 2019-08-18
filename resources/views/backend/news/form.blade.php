@extends('backend/layout')

@if ($data->page_type == 'add')
    <!-- page title -->
    @section('title', 'Create News | ' . env('APP_NAME',''))
@else
    <!-- page title -->
    @section('title', 'Edit News | ' . env('APP_NAME',''))
@endif
@section('content')
<section class="content-header">
    <h1>News</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.news') }}">News</a></li>
        <li class="active">{{$data->h1}}</li>
    </ol>
</section>
<!-- Main content -->
<section id="news-content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"> {{$data->h1}} </h3>
                    <a class="btn btn-primary pull-right" href="{{ route('admin.news') }}">Back</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <!-- <strong>Whoops!</strong> There were some problems with your input.<br><br> -->
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{ Form::open(array('url' => url($data->form_action), 'method' => 'POST', 'id' => 'news-form')) }}
                    {{ Form::hidden('id', $data->id, array('id' => 'news_id')) }}

                    <div id="form-title" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">required</span>
                            <strong class="field-title">title</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::text('title',$data->title , array('placeholder' => '', 'class' => 'form-control validate[required]', 'data-prompt-position' => 'bottomRight:0,11')) }}
                        </div>
                    </div>

                    <div id="form-content" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">required</span>
                            <strong class="field-title">Konten</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            {{ Form::textarea('content',$data->content , array('id' => 'ckview', 'rows' => '3', 'placeholder' => '', 'class' => 'form-control validate[required]', 'data-prompt-position' => 'bottomLeft:0,325')) }}
                        </div>
                    </div>

                    <div id="form-publication_date" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-success label-required">Optional</span>
                            <strong class="field-title">Publish Date</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            {{ Form::text('publication_date', strtotime($data->publication_date)!=''?date("Y-m-d", strtotime($data->publication_date)):'', array('placeholder' => 'yyyy-mm-dd', 'class' => 'form-control date isDatepicker')) }}
                            </div>
                        </div>
                    </div>

                    <div id="form-button" class="form-group no-border">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center top20">
                            <button type="submit" name="submit" id="btn-admin-member-submit" class="btn btn-primary">{{ $data->button }}</button>
                        </div>
                    </div>
                    {{ Form::close() }}
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

@section('body-class', 'custom-select')
{{--@section('title', $data->page_title)--}}

@section('css-scripts')
<link href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('js-scripts')
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.ja.min.js') }}" charset="UTF-8"></script>
<!-- validationEngine -->
<script src="{{ asset('js/3rdparty/validation-engine/jquery.validationEngine-ja.js') }}"></script>
<script src="{{ asset('js/3rdparty/validation-engine/jquery.validationEngine.js') }}"></script>
<!-- TinyMCE -->
<script src="{{asset('js/tinymce/jquery.tinymce.min.js')}}"></script>
<script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>
<script type="text/javascript">
    tinymce.init({
      selector: "#ckview",theme: "modern",width: '100%',height: 300,
      plugins: [
           "advlist autolink link image lists charmap print preview hr anchor pagebreak",
           "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
           "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
      ],
      toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
      toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
      image_advtab: true ,
      language : 'en',
      relative_urls : false,
      remove_script_host : false,
      convert_urls : true,
      external_filemanager_path: root_url + "/js/filemanager/",
      filemanager_title:"Responsive Filemanager" ,
      external_plugins: { "filemanager" : "plugins/responsivefilemanager/plugin.min.js"},
      init_instance_callback: "initialiseInstance",
      resize: false,
      height : 250,
      });
  </script>
<script src="{{ asset('js/backend/news/form.js') }}"></script>
@endsection
