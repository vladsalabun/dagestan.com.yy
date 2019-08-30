@extends('cp.cp_head')

@section('page_header')
Все пользователи
@endsection

@section('content')
<!-- Страница: --->
<div class="box">

    <!-- /.box-header -->
    <div class="box-body no-padding">
      <table class="table table-striped">
        <tbody>
        <tr>
          <th style="width: 10px">ID:</th>
          <th>Права:</th>
          <th>Имя:</th>
          <th>email:</th>
          <th>Зарегистрирован:</th>
          <th>Адрес:</th>
          <th>Телефон:</th>
          <th>Ред.</th>
        </tr>
@forelse ($items as $item)
        <tr>
          <td style="widtd: 10px">{{$item->id}}</td>
          <td><?php if($item->role_id == 1) echo 'admin';?></td>
          <td>{{$item->name}}</td>
          <td>{{$item->email}}</td>
          <td>{{$item->created_at}}</td>
          <td>{{$item->address}}</td>
          <td>{{$item->tel}}</td>
          <td><a href="{{URL::to('/')}}/cp/edit_users/{{$item->id}}"><i class="fa fa-edit"></i></a></td>
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