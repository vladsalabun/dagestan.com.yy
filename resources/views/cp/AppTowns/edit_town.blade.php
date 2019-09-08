@extends('cp.cp_head')

@section('page_header')
Изменить город:
@endsection

@section('content')
<!-- Страница: --->
<ol class="breadcrumb">
    <li><a href="{{URL::to('/')}}/cp"><i class="fa fa-dashboard"></i> Главная</a></li>
    <li><a href="{{URL::to('/')}}/cp/towns">Все города</a></li>
    <li class="active">Изменить город:</li>
</ol>



<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
    
<form method="post" action="{{URL::to('/')}}/cp/post_edit_town" autocomplete="off" enctype="multipart/form-data">
{{ csrf_field() }}

<input type="hidden" value="{{$town->id}}" name="id">

<table class="table table-bordered">
<tbody>
<tr>
    <th>
        <input type="text" class="form-control" value="{{$town->town}}" name="town" placeholder="Город" required>
    </th>
    <th style="width: 250px">
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-map-pin"></i></span>
    <input type="text" class="form-control" id="lng" placeholder="longitude" name="longitude" value="{{$town->longitude}}">
</div>
        <br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-map-pin"></i></span>
    <input type="text" class="form-control" id="lat" placeholder="latitude" name="latitude" value="{{$town->latitude}}">
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
<p>
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
        Удалить город
    </button>
</p>
<p><input type="submit" name="submit" class="btn btn-success" value="Сохранить"></p>
    
        
    </td>
</tr>
    
    </tbody>
</table>
     
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-body">
      <h5 class="modal-title" id="exampleModalLabel">Вы уверены, что хотите удалить город?</h5>
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