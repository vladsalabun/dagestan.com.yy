@extends('cp.cp_head')

@section('page_header')
Редактировать категорию
@endsection


@section('content')
<!-- Страница: --->
<ol class="breadcrumb">
    <li><a href="{{URL::to('/')}}/cp"><i class="fa fa-dashboard"></i> Главная</a></li>
    <li><a href="{{URL::to('/')}}/cp/adscategories">Все категории объявлений</a></li>
    <li class="active">Добавить категорию:</li>
</ol>



<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
    
<form method="post" action="{{URL::to('/')}}/cp/post_edit_adscategories" autocomplete="off" enctype="multipart/form-data">
{{ csrf_field() }}

<input type="hidden" value="{{$item->id}}" name="id">

<table class="table table-bordered">
<tbody>
<tr>
    <th>
        <input type="text" class="form-control" value="{{$item->name}}" name="name" placeholder="Название категории" required>
    </th>
    <th style="width: 250px">
    </th>
</tr>
    
<tr>
    <td>
    
<div class="form-group mb-3 form-town-block">
    <p>Родительская категория:</p>
    <select class="form-control pt-2 pb-2 pl-3 pr-1" name="parent_id" required>
        <option value="0">0</option>
<?php 
    if(count($children) == 0) {
    foreach ($categories as $key => $value) { 
        // Нельзя сделать себя родителем:
        if($item->id != $value->id) {
?>
        <option value="{{$value->id}}" @if ($item->parent_id == $value->id) selected @endif >{{$value->name}}</option>
<?php 
        }
    } 
    }

?>
    </select>
</div>



    </td>
    <td>
    


    </td>
</tr>

<tr>
    <td></td>
    <td>
<p>
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
        Удалить категорию
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
      <h5 class="modal-title" id="exampleModalLabel">Вы уверены, что хотите удалить категорию?</h5>
<?php 
          if(count($children) > 0) {
?>  
    <p>Будут удалены так же дочерние категории:</p>
    @forelse($children as $child)
        - <a href="{{URL::to('/')}}/cp/edit_adscategories/{{$child->id}}">{{$child->name}}</a><br>
    @empty
    @endforelse
<?php     
          } 
?>
      
      <p></p>
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
