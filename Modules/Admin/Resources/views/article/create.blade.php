 @extends('admin::layouts.master')

@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li><a href="{{ route('admin.home') }}">Trang chủ</a></li>
		<li><a href=" {{ route('admin.get.list.article')  }} "title="Bài viết">Bài viết</a></li>
		<li class="active">Cập nhật</li>
	</ol>
</div>
<div class="container">
	@include("admin::article.form")

</div>

@stop
