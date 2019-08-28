@extends('cp.cp_head')

@section('page_header')
Редактировать страницу:
@endsection

@section('content')
<ol class="breadcrumb">
    <li><a href="{{URL::to('/')}}/cp"><i class="fa fa-dashboard"></i> Главная</a></li>
    <li><a href="{{URL::to('/')}}/cp/pages">Все страницы</a></li>
    <li class="active">Редактировать страницу:</li>
</ol>



<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
    
<form method="post" action="{{URL::to('/')}}/cp/post_edit_page" autocomplete="off" enctype="multipart/form-data">
{{ csrf_field() }}

<input type="hidden" value="{{$page->id}}" name="id">

<table class="table table-bordered">
<tbody>
<tr>
    <th>
        <p><input type="text" class="form-control" value="{{$page->title}}" name="title" placeholder="Заголовок" required></p>
    </th>
    <th style="width: 250px">

    </th>
</tr>
    
<tr>
    <td>
    <p class="">
        Постоянная ссылка: <a href="" id="edit_permalink">изменить <span class="fa fa-edit"></span></a><br>
        <span id="permalink" slug="{{$page->slug}}"><a href="{{URL::to('/')}}/page/{{$page->slug}}" target="blank">{{URL::to('/')}}/page/{{$page->slug}}</a></span>
    </p>
        <input type="hidden" value="{{$page->slug}}" name="slug" id="hidden_slug_field">
        <textarea name="text" id="company_description" rows="10" cols="30">{{$page->text}}</textarea>
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
    <option value="1" @if($page->publish_status == 1) selected @endif>Опубликовано</option>
    <option value="0" @if($page->publish_status == 0) selected @endif>Черновик</option>
  </select>
</div>


<p><b>Дата:</b></p>
<div class="input-group date ">
    <input type="text" name="publish_date" class="form-control" 
    value="<?php echo explode(' ',$page->date)[0];?>" name="date" id="datepicker">
    <div class="input-group-addon">
        <span class="glyphicon glyphicon-th"></span>
    </div>
</div>
<br>   
<div class="input-group">
    <input type="text" name="time" class="form-control timepicker" value="<?php echo explode(' ',$page->date)[1];?>">

    <div class="input-group-addon">
      <i class="fa fa-clock-o"></i>
    </div>
</div> 


    </td>
</tr>

<tr>
    <td></td>
    <td>
        <p><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
          Удалить страницу
        </button></p>
        <p>
        <input type="submit" name="submit" class="btn btn-success" value="Сохранить изменения">
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
      <h5 class="modal-title" id="exampleModalLabel">Вы уверены, что хотите удалить страницу?</h5>
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



<script>

// Клік на об'єкт:
$('body').on('click', '#edit_permalink', function() {
    
    // Слаг:
    var slug = $('#permalink').attr('slug');
    
    // Очищаю:
    $('#permalink').text('');
    
    // Открываю текстовое поле для ввода нового слага:
    $('#permalink').append('<br><input type="text" class="form-control" value="' + slug + '" id="new_slug_field" name="new_slug"><br> <span class="btn btn-success" id="save_new_slug">Сохранить слаг</span> <span class="btn btn-danger" id="cancel_new_slug">Отмена</span> <span id="error_span"></span><br>');

    return false;
    
});

// Сохранить новый слаг:
$('body').on('click', '#save_new_slug', function() {
    
    // Слаг:
    var new_slug_field = $('#new_slug_field').val();
    
        // Відправляю дані:
        $.ajax({
            type: 'get',
            url: '{{URL::to('/')}}/api/check_slug?slug=' + new_slug_field,
        })
        .done (function (data) {
            
            if(data.status == 404) {
                // Открываю текстовое поле для ввода нового слага:
                $('#error_span').append('<span class="ml-1 text-danger">Слаг уже существует. Введите другой</span>');
            } else {
                // Обновляю скрытое поле:
                $('#hidden_slug_field').val(data.slug);
                $('#permalink').attr('slug', data.slug);
                
                // Возвращаю ссылку:
                $('#permalink').text('');
                $('#permalink').append('<a href="{{URL::to('/')}}/page/' + data.slug + '" target="blank">{{URL::to('/')}}/page/' + data.slug + '</a>'); 
            }
        })
        .fail (function () {
            //console.log('form error');
        });

    return false;
    
});

// Сохранить новый слаг:
$('body').on('click', '#cancel_new_slug', function() {
    
    // Слаг:
    var slug = $('#permalink').attr('slug');

    // Возвращаю форму:
    $('#permalink').text('');
    $('#permalink').append('<a href="{{URL::to('/')}}/page/' + slug + '" target="blank">{{URL::to('/')}}/page/' + slug + '</a>'); 
    
    return false;
    
});


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
