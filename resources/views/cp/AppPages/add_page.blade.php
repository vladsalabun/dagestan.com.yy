@extends('cp.cp_head')

@section('page_header')
Добавить новую страницу:
@endsection

@section('content')
<ol class="breadcrumb">
    <li><a href="{{URL::to('/')}}/cp"><i class="fa fa-dashboard"></i> Главная</a></li>
    <li><a href="{{URL::to('/')}}/cp/pages">Все страницы</a></li>
    <li class="active">Добавить новую страницу:</li>
</ol>
@endsection
