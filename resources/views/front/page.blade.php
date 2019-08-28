@extends('layouts.app')

@section('page_header')Объявление 1 @endsection

@section('content')



<!-- Страница: --->
<div class="container mt-2">
    <div class="row pt-5">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h2>{{$page->title}}</h2>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
        {!! $page->text !!}
        </div>
    </div>
</div>

<!-- /Страница --->


<script>

</script>

@endsection
