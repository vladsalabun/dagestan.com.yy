@extends('cp.cp_head')

@section('page_header')
Объявления
@endsection

@section('content')
<!-- Страница: --->
<div class="box">
    <div class="box-header">
      <p><a href="{{URL::to('/')}}/cp/add_ads" class="btn btn-info">Добавить объявление</a></p>
    </div>
    
<!-- /.box-header -->
<div class="box-body no-padding">
    <table class="table table-striped">
    <tbody>
        <tr>
<th>ID:</th>
<th>Город:</th>
<th>Тип:</th>
<th>Добавил:</th>
<th>Заголовок:</th>
<th>Дата:</th>
<th>Редактировать:</th>
        </tr>
    @forelse ($items as $item)
        <tr>
<td>{{$item->id}}</td>
<td>{{$item->town->town}}</td>
<td>@if($item->type == 1) Организация @elseif($item->type == 2) Специалист @endif </td>
<td>{{$item->user->name}}</td>
<td>{{$item->title}}</td>
<td>{{$item->date}}</td>
<td><a href="{{URL::to('/')}}/cp/edit_ads/{{$item->id}}" class="btn btn-primary btn-sm">Редактировать</a></td>

        </tr>
    @empty
    @endforelse
    </tbody>
    </table>
</div>
<!-- /.box-body -->

</div>
    
<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <div class="p-3 pagi-block">
        <div class="text-left"> {{$items->links('pagination')}}</div>
    </div>
</div>

<!-- /Страница --->

<script>
</script>

@endsection