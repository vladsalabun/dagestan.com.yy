@extends('cp.cp_head')

@section('page_header')
Баннеры
@endsection

@section('content')
<!-- Страница: --->
<ol class="breadcrumb">
    <li><a href="{{URL::to('/')}}/cp"><i class="fa fa-dashboard"></i> Главная</a></li>
    <li><a href="{{URL::to('/')}}/cp/banners">Все баннеры</a></li>
    <li class="active">Добавить баннер:</li>
</ol>



<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
    
<form method="post" action="{{URL::to('/')}}/cp/post_add_banners" autocomplete="off" enctype="multipart/form-data">
{{ csrf_field() }}

<table class="table table-bordered">
<tbody>
<tr>
    <th>
        <input type="text" class="form-control" value="" name="title" placeholder="Заголовок" required>
    </th>
    <th style="width: 250px">
        <input type="file" name="img" id="exampleInputFile">
    <p class="help-block">Формат .jpg или .png</p>
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
        <input type="submit" name="submit" class="btn btn-success" value="Добавить баннер">
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