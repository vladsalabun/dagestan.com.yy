@extends('cp.cp_head')

@section('page_header')
Баннеры
@endsection

@section('content')
<!-- Страница: --->
<div class="box">
    <div class="box-header">
      <p><a href="{{URL::to('/')}}/cp/add_banners" class="btn btn-info">Добавить баннер</a></p>
    </div>
    
<!-- /.box-header -->
<div class="box-body no-padding">
    <table class="table table-striped">
    <tbody>
        <tr>
            <th style="width: 10px">ID:</th>
            <th>Титул:</th>
            <th>Изображение:</th>
        </tr>
    @forelse ($items as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td><a href="{{URL::to('/')}}/cp/edit_banners/{{$item->id}}">{{$item->title}}</a></td>
            <td><img src="{{URL::to('/')}}/storage/{{$item->img}}" style="max-width: 150px;"></td>
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