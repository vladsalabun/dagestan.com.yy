@extends('cp.cp_head')

@section('page_header')
Добавить объявление
@endsection

@section('content')
<!-- Страница: --->
<div class="box">
    <div class="box-header">
      <p><a href="{{URL::to('/')}}/add_ads" class="btn btn-info">Добавить ads</a></p>
    </div>
    
<!-- /.box-header -->
<div class="box-body no-padding">
    <table class="table table-striped">
    <tbody>
        <tr>
            <th style="width: 10px">ID:</th>
            <th>Город:</th>
        </tr>
    @forelse ($items as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td><a href="{{URL::to('/')}}/edit_ads/{{$item->id}}">{{$item->town}}</a></td>
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