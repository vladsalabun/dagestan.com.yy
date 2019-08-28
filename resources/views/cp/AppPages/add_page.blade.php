@extends('cp.cp_head')

@section('page_header')
Добавить новую страницу:
@endsection

@section('content')
<ol class="breadcrumb">
    <li><a href="{{URL::to('/')}}/cp"><i class="fa fa-dashboard"></i> Главная</a></li>
    <li><a href="{{URL::to('/')}}/cp/pages">Все страницы</a></li>
    <li class="active">Добавить новую страницу:</li>
</ol>



<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
    
<form method="post" action="{{URL::to('/')}}/cp/post_add_page" autocomplete="off" enctype="multipart/form-data">
{{ csrf_field() }}

<table class="table table-bordered">
<tbody>
<tr>
    <th>
        <input type="text" class="form-control" value="" name="title" placeholder="Заголовок" required>
    </th>
    <th style="width: 250px">
    </th>
</tr>
    
<tr>
    <td>
        <textarea name="text" id="company_description" rows="10" cols="30"></textarea>
        <script>
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace( 'company_description' );
        </script>
    </td>
    <td>
    
<div class="form-group">
<p><b>Статус:</b></p>
  <select class="form-control" name="publish_status">
    <option value="1">Опубликовано</option>
    <option value="0">Черновик</option>
  </select>
</div>
<p><b>Дата:</b></p>
<div class="input-group date ">
    <input type="text" name="publish_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="date" id="datepicker">
    <div class="input-group-addon">
        <span class="glyphicon glyphicon-th"></span>
    </div>
</div>
<br>   
<div class="input-group">
    <input type="text" name="time" class="form-control timepicker" value="<?php echo date('H:i'); ?>">

    <div class="input-group-addon">
      <i class="fa fa-clock-o"></i>
    </div>
</div> 


    </td>
</tr>

<tr>
    <td></td>
    <td>
        <input type="submit" name="submit" class="btn btn-success" value="Добавить страницу">
    </td>
</tr>
    
    </tbody>
</table>
        
</form>
 
    </div>
</div>   



<script>

$(function () {
    
    //Date picker
    $('#datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
    })

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false,
      showMeridian: false,
    })

});

</script>
@endsection
