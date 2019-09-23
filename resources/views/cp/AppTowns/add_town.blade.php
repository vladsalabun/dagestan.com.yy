@extends('cp.cp_head')

@section('page_header')
Добавить город:
@endsection

@section('content')
<!-- Страница: --->
<ol class="breadcrumb">
    <li><a href="{{URL::to('/')}}/cp"><i class="fa fa-dashboard"></i> Главная</a></li>
    <li><a href="{{URL::to('/')}}/cp/towns">Все города</a></li>
    <li class="active">Добавить новый город:</li>
</ol>



<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
    
<form method="post" action="{{URL::to('/')}}/cp/post_add_town" autocomplete="off" enctype="multipart/form-data">
{{ csrf_field() }}

<table class="table table-bordered">
<tbody>
<tr>
    <th>
        <input type="text" class="form-control" value="" name="town" placeholder="Город" required>
    </th>
    <th style="width: 250px">
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-map-pin"></i></span>
    <input type="text" class="form-control" id="lat" placeholder="longitude" name="latitude" value="">
</div>
<br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-map-pin"></i></span>
    <input type="text" class="form-control" id="lng" placeholder="latitude" name="longitude" value="">
</div>
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
        <input type="submit" name="submit" class="btn btn-success" value="Добавить город">
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