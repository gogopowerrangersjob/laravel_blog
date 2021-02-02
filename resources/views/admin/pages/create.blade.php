@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Добавить страницу
		</h1>
	</section>

	<!-- Main content -->
	<section class="content">
		{{Form::open([
			'route' => 'pages.store'
		])}}
		<!-- Default box -->
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Добавляем страницу</h3>
				@include('admin.errors')
			</div>
			<div class="box-body">
				<div class="col-md-6">
					<div class="form-group">
						<label for="exampleInputEmail1">Название</label>
						<input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="title" value="{{old('title')}}">
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label for="exampleInputEmail1">Текст</label>
						<textarea name="text" id="" cols="30" rows="10" class="form-control"></textarea>
					</div>
				</div>
			</div>
			<div class="box-header with-border">
				<h3 class="box-title">SEO</h3>
			</div>
			<div class="box-body">
				<div class="col-md-6">
					<div class="form-group">
						<label for="exampleInputEmail1">Title</label>
						<input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="seo_title" value="{{old('seo_title')}}">
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label for="exampleInputEmail1">Description</label>
						<input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="seo_description" value="{{old('seo_description')}}">
					</div>
				</div>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button class="btn btn-default">Назад</button>
				<button class="btn btn-success pull-right">Добавить</button>
			</div>
			<!-- /.box-footer-->
		</div>
		<!-- /.box -->
		{{Form::close()}}
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection