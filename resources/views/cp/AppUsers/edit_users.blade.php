@extends('cp.cp_head')

@section('page_header')
Редактировать пользователя
@endsection

@section('content')
<!-- Страница: --->
<ol class="breadcrumb">
    <li><a href="{{URL::to('/')}}/cp"><i class="fa fa-dashboard"></i> Главная</a></li>
    <li><a href="{{URL::to('/')}}/cp/users">Все пользователи</a></li>
    <li class="active">Редактировать пользователя:</li>
</ol>



<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
    
<form method="post" action="{{URL::to('/')}}/cp/post_edit_users" autocomplete="off" enctype="multipart/form-data">
{{ csrf_field() }}

<input type="hidden" value="{{$item->id}}" name="id">

<table class="table table-bordered">
<tbody>
<tr>
    <th>
        <p><input type="text" class="form-control" value="{{$item->name}}" name="name" placeholder="Название категории" required></p>
        <p><input type="text" class="form-control" value="{{$item->email}}" name="email" placeholder="email" required></p>
        <p><input type="text" class="form-control" value="{{$item->address}}" name="address" placeholder="Адрес"></p>
        <p><input type="text" class="form-control" value="{{$item->tel}}" name="tel" placeholder="Телефон"></p>
    </th>
    <th style="width: 250px">
        <p>Права доступа:</p>
    <select class="form-control pt-2 pb-2 pl-3 pr-1" name="role_id">
        <option value="1" @if($item->role_id == 1) selected @endif >admin</option>
        <option value="2" @if($item->role_id == 2) selected @endif >пользователь</option>
    </select>
    <br>
        <p>Блокировка:</p>
    <select class="form-control pt-2 pb-2 pl-3 pr-1" name="is_ban">
        <option value="0" @if($item->is_ban == 0) selected @endif>Не заблокирован</option>
        <option value="1" @if($item->is_ban == 1) selected @endif >Заблокирован</option>
    </select>
    </th>
</tr>
    
<tr>
    <td>
    




    </td>
    <td>


    </td>
</tr>

<tr>
    <td></td>
    <td>
<p>
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
        Удалить пользователя
    </button>
</p>
<p>
<input type="submit" name="submit" class="btn btn-success" value="Сохранить">
</p>
    
        
    </td>
</tr>
    
    </tbody>
</table>
    
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-body">
      <h5 class="modal-title" id="exampleModalLabel">Вы уверены, что хотите удалить пользователя?</h5>
      </div>
      <div class="modal-footer">
        <input type="submit" name="delete" class="btn btn-danger" value="Удалить">
      </div>
    </div>
  </div>
</div>

    
</form>
 
    </div>
</div>  

<!-- /Страница --->
<script>
</script>

@endsection
