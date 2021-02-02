@extends('layout')

@section('content')
<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
        	<div class="col-md-8">
        		{!! $page->title !!}
        	</div>
            <div class="col-md-8">
            	{!! $page->text !!}
            </div>
            @include('pages._sidebar')
        </div>
    </div>
</div>
<!-- end main content-->
@endsection