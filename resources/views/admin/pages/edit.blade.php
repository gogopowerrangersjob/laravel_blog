@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Страницу
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
   {{Form::open([
     'route'	=>	['pages.update', $page->id],
     'method'	=>	'put'
     ])}}
     <!-- Default box -->
     <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Обновляем страницу</h3>
        @include('admin.errors')
      </div>
      <div class="box-body">
        <div class="col-md-6">
          <div class="form-group">
            <label for="exampleInputEmail1">Название</label>
            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{$page->title}}" name="title">
          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <label for="exampleInputEmail1">Текст</label>
            <textarea name="text" id="" cols="30" rows="10" class="form-control">{{$page->text}}</textarea>
          </div>
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <a href="{{route('pages.index')}}" class="btn btn-default">Назад</a>
        <button class="btn btn-warning pull-right">Изменить</button>
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