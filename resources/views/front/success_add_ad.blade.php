@extends('layouts.app')

@section('page_header')Объявление добавлено! @endsection

@section('content')



<!-- Добавление объявления: --->
<div class="container mt-2">
    <div class="row pt-5">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
            <h2>Ваше объявление добавлено!</h2>
            <p>Очень скоро ваше объявление проверит модератор и опубликует его на сайте.<br> А пока ожидаете можете <a href="{{URL::to('/')}}/add_ad">добавить еще одно объявление</a>.</p>
        </div>
    </div>
</div>

<!-- /Добавление объявления --->
@endsection
