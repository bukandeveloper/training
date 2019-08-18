@extends('auth.layouts.admin_app')

<!-- page title -->
@section('title', 'パスワード変更フォーム | ' . env('APP_NAME',''))
@section('description', 'パスワードが変更されました | ' . env('APP_NAME',''))

@section('content')

<div class="wrap-default">
	<div class="wrap-content_sm">
	    <div class="text-center padd-content">
	      <p class="padd40_top gold">パスワードが変更されました。</p>
	    </div>
	</div>
	<!-- button back -->
	<div class="text-center padd-content_bottom">
	  <div class="btn-brown arrow-left"><a href="{{ url('admin/login') }}">ログインへ戻る</a></div>
	</div>
</div>
@endsection
