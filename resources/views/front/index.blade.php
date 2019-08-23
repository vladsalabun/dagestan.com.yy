@extends('layouts.app')

@section('page_header')Объявления Дагестана@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <p class="mt-5"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Какие у меня успехи?</p>
            <ol>
                <li>Установил Laravel</li>
                <li>Включил регистрацию</li>
                <li>Создал роуты</li>
                <li>Создал шаблон вида</li>
                <li>Подключил библиотеки: jquery, bootstrap, ckeditor, moment, font awesome</li>
                <li>Установил <a href="{{URL::to('/')}}/cp">админ-панель LTE</a></li>
                <li>Создал разделы в админке для баннеров, категорий, конфигураций, городов и объявлений</li>
                <li>Сверстал меню сверху, поиск и футер</li>
            </ol>
        <p><i class="fa fa-code" aria-hidden="true"></i> А теперь, макет, сверстайся, пожалуйста!</p>
        </div>
    </div>
</div>
@endsection
