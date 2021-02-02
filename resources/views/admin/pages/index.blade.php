@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Blank page
			<small>it all starts here</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Examples</a></li>
			<li class="active">Blank page</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
			<!-- Default box -->
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Листинг сущности</h3>
					@include('admin.errors')
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="form-group">
						<a href="{{route('pages.create')}}" class="btn btn-success">Добавить</a>
					</div>
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>ID</th>
								<th>Название</th>
								<th>Действия</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($pages as $page)
							<tr>
								<td>{{$page->id}}</td>
								<td>{{$page->title}}</td>
								<td>
									<a href="{{route('pages.edit', $page->id)}}" class="fa fa-pencil"></a>
									{{Form::open(['route'=>['pages.destroy', $page->id], 'method' => 'delete'])}}
									<button onclick="return confirm('Вы уверены?')" type="submit" class="delete">
										<i class="fa fa-remove"></i>
									</button>
									{{Form::close()}}
								</td>
							</tr>
							@endforeach
						</tfoot>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	@endsection