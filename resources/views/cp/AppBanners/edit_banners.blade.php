@extends('cp.cp_head')

@section('page_header')
Баннеры
@endsection

@section('content')
<!-- Страница: --->
<ol class="breadcrumb">
    <li><a href="{{URL::to('/')}}/cp"><i class="fa fa-dashboard"></i> Главная</a></li>
    <li><a href="{{URL::to('/')}}/cp/banners">Все баннеры</a></li>
    <li class="active">Изменить баннер:</li>
</ol>



<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
    
<form method="post" action="{{URL::to('/')}}/cp/post_edit_banners" autocomplete="off" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" value="{{$item->id}}" name="id">
<table class="table table-bordered">
<tbody>
<tr>
    <th>

<input type="text" class="form-control" value="{{$item->title}}" name="title" placeholder="Заголовок" required>
    </th>
    <th style="width: 250px">
@if ($item->img != null)    
<div class="input-group">
        <img src="{{URL::to('/')}}/storage/{{$item->img}}" style="max-width: 100%;">
        <div class="checkbox">
            <label>
              <input type="checkbox" name="delete_img" value="2">
                Удалить изображение
            </label>
        </div>
</div>
@else
<input type="file" name="img" id="exampleInputFile">
<p class="help-block">Формат .jpg или .png</p>
@endif

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
<p><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
          Удалить баннер
</button></p>
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
      <h5 class="modal-title" id="exampleModalLabel">Вы уверены, что хотите удалить баннер?</h5>
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