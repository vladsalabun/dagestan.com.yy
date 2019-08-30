@extends('cp.cp_head')

@section('page_header')
Добавить категорию:
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
    
<form method="post" action="{{URL::to('/')}}/cp/post_add_adscategories" autocomplete="off" enctype="multipart/form-data">
{{ csrf_field() }}

<table class="table table-bordered">
<tbody>
<tr>
    <th>
        <input type="text" class="form-control" value="" name="name" placeholder="Название категории" required>
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
<?php foreach ($items as $key => $value) { ?>
        <option value="{{$value->id}}">{{$value->name}}</option>
<?php } ?>
    </select>
</div>



    </td>
    <td>
    


    </td>
</tr>

<tr>
    <td></td>
    <td>
        <input type="submit" name="submit" class="btn btn-success" value="Добавить категорию">
    </td>
</tr>
    
    </tbody>
</table>
        
</form>
 
    </div>
</div>  

<!-- /Страница --->
<script>
</script>

@endsection