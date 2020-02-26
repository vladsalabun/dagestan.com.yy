@extends('cp.cp_head')

@section('page_header')
Редактировать объявление:
@endsection

@section('content')
<ol class="breadcrumb">
    <li><a href="{{URL::to('/')}}/cp"><i class="fa fa-dashboard"></i> Главная</a></li>
    <li><a href="{{URL::to('/')}}/cp/ads">Все объявления</a></li>
    <li class="active">Редактировать объявление:</li>
</ol>

<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
    
<form method="post" action="{{URL::to('/')}}/cp/post_edit_ads" autocomplete="off" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" value="{{$item->id}}" name="id">
<table class="table table-bordered">
<tbody>
<tr>
    <th>

        <p><input type="text" class="form-control" value="{{$item->title}}" name="title" placeholder="Заголовок" required></p>
        <p>Автор: 
        <span class="ml-3 mr-3" id="author_name" user_id="{{$item->user_id}}" user_name=""></span>
            <a href="" id="edit_user"> <span class="fa fa-edit"></span></a>
          <br>

       <input type="text" name="search" id="search" class="form-control search-hint ea-search-input " placeholder="Введите имя пользователя" style="outline: none !important; display: none;" value="">
       
       <!---Відкривашка: -->
        <div class="row search-hint" id="hint_board" style="display:none; ">
               <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 search-hint">
                   <div class="p-1 bg-light search-hint" style="max-height: 200px; overflow: scroll;">
                   <ul class="search-hint" id="kw_list"></ul>
                   </div>
               </div>
        </div>
       
       
       </p>
        <input type="hidden" value="{{$item->user_id}}" name="user_id" id="hidden_user_id_field">
    </th>
    <th style="width: 250px">
<div class="form-group">
<p><b>Статус:</b></p>
  <select class="form-control" name="moderation">
    <option value="1" @if($item->moderation == 1) selected @endif>Опубликовано</option>
    <option value="0" @if($item->moderation == 0) selected @endif>На модерации</option>
  </select>
</div>
    </th>
</tr>
    
<tr>
    <td>
        <textarea name="description" id="company_description" rows="10" cols="30" placeholder="1" data-sample-short="444">{{$item->description}}</textarea>
        <script>
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace( 'company_description');
        </script>
        <p></p>
        <p><input type="text" class="form-control" value="{{$item->name}}" name="name" placeholder="Имя"></p>
        <p><input type="text" class="form-control" value="{{$item->surname}}" name="surname" placeholder="Фамилия"></p>
        <p><input type="text" class="form-control" value="{{$item->working_hours}}" name="working_hours" placeholder="Время работы"></p>
        <p><input type="text" class="form-control" value="{{$item->work_expiriens}}" name="work_expiriens" placeholder="Опыт работы"></p>
<br>
<style>
.company_link { color: #69BEFD; text-decoration: underline; }
.company_link:hover { cursor: pointer;}
.company_logo { width: 30px; float: left; margin-right: 3px;}   
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>	
<script src="http://dagestan.com.yy/adminlte/jquery/dist/jquery.min.js"></script>
 
<div id="mapid" style="width: 100%; height: 400px; "></div>
<script>

    var greenIcon = new L.Icon({
      iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
      shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowSize: [41, 41]
    });

	var mymap = L.map('mapid').setView([{{$max_center[0]}}, {{$max_center[1]}}], {{$initZoom}});

	L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={{$openstreetmap_api_key}}', {
		maxZoom: {{$maxZoom}},
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox.streets'
	}).addTo(mymap);

    var markerGroup = L.layerGroup().addTo(mymap);
    
<?php if ($item->longitude != null and $item->latitude != null) { ?>
    L.marker([{{$item->latitude}}, {{$item->longitude}}], {icon: greenIcon}).addTo(markerGroup);
<?php } ?>
    
function onMapClick(e) {

    $("#lng").val(e.latlng.lng.toFixed(8));
    $("#lat").val(e.latlng.lat.toFixed(8));

    markerGroup.clearLayers();
    
    L.marker([e.latlng.lat,e.latlng.lng], {icon: greenIcon}).addTo(markerGroup).on('click', function(e) {
        //console.log(e.latlng);
    });
    
}

mymap.on('click', onMapClick);

    
</script>

        <div id="items" style="margin: 10px; ">
        </div>
        <div id="new_coordinates"></div>       
         
    </td>
    <td>

        <?php if($item->img == null) { ?>

            <input type="file" name="img" id="exampleInputFile">
            <p class="help-block">Формат .jpg или .png</p>

        <?php } else { ?>

<div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Изображение:</h3>
        </div>
        <div class="box-body">
          <img src="{{URL::to('/')}}/storage/{{$item->img}}" style="max-width: 250px;">
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <label>
              <input type="checkbox" name="delete_img">
              Удалить изображение
            </label>
        </div>
        <!-- /.box-footer-->
      </div>
            
        <?php }?>
    
    
     

    
    
    
<div class="form-group">
<p><b>Тип объявления:</b></p>
  <select class="form-control" name="type">
    <option value="1" @if($item->type == 1) selected @endif>Организация</option>
    <option value="2" @if($item->type == 2) selected @endif>Специалист</option>
  </select>
</div>


<div class="form-group">
<p><b>Город:</b></p>
  <select class="form-control" name="town_id">
@forelse($towns as $town)
<option value="{{$town->id}}" @if($item->town_id == $town->id) selected @endif>{{$town->town}}</option>
@empty
@endforelse

  </select>
</div>

<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-money"></i></span>
    <input type="text" class="form-control input-sm" value="{{$item->average_price}}" name="average_price" placeholder="цена">
</div>
<br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-fw fa-envelope-o"></i></span>
    <input type="text" class="form-control input-sm" value="{{$item->email}}" name="email" placeholder="e-mail">
</div>
<br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-fw fa-phone"></i></span>
    <input type="text" class="form-control input-sm" value="{{$item->phone}}" name="phone" placeholder="phone">
</div>
<br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-fw fa-facebook"></i></span>
    <input type="text" class="form-control input-sm" value="{{$item->fb}}" name="fb" placeholder="facebook">
</div>
<br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-fw fa-odnoklassniki"></i></span>
    <input type="text" class="form-control input-sm" value="{{$item->ok}}" name="ok" placeholder="odnoklassniki">
</div>
<br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-fw fa-vk"></i></span>
    <input type="text" class="form-control input-sm" value="{{$item->vk}}" name="vk" placeholder="vk">
</div> 
<br>    
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-fw fa-instagram"></i></span>
    <input type="text" class="form-control" value="{{$item->instagram}}" placeholder="instagram" name="instagram">
</div>
<br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-fw  fa-external-link"></i></span>
    <input type="text" class="form-control" value="{{$item->site}}" placeholder="site" name="site">
</div>
<br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-fw fa-home"></i></span>
    <input type="text" class="form-control" value="{{$item->address}}" placeholder="address" name="address">
</div>
        <br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-map-pin"></i></span>
    <input type="text" class="form-control" id="lng" placeholder="longitude" name="longitude" value="{{$item->longitude}}">
</div>
        <br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-map-pin"></i></span>
    <input type="text" class="form-control" id="lat" placeholder="latitude" name="latitude" value="{{$item->latitude}}">
</div>

 <br>
        
        



<p><b>Дата:</b></p>
<div class="input-group date ">
    <input type="text" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="date" id="datepicker">
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

<br>
<h3 class="box-title">Категории:</h3>
<br>

@forelse($categories as $category_name => $sub_categories)
    @if (count($sub_categories) > 0) 
    
<div class="box box-warning">
    <div class="box-header with-border">
      <h3 class="box-title">{{$category_name}}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        @forelse($sub_categories as $category_id => $sub_category_name)
<div class="">
  <div class="radio">
    <label>
      <input type="radio" name="category" id="optionsRadios{{$category_id}}" value="{{$category_id}}" @if($category_id == $ad_category) checked @endif>
      {{$sub_category_name}}
    </label>
  </div>
</div>
        @empty
        @endforelse
    @else
        
    @endif
    </div>
    <!-- /.box-body -->
</div>
    
@empty
@endforelse


    </td>
</tr>

<tr>
    <td></td>
    <td>
<p><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
          Удалить объявления
        </button></p>
        <input type="submit" name="submit" class="btn btn-success" value="Сохранить">
    </td>
</tr>
    
    </tbody>
</table>
    
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-body">
      <h5 class="modal-title" id="exampleModalLabel">Вы уверены, что хотите удалить это объявление?</h5>
      </div>
      <div class="modal-footer">
        <input type="submit" name="delete" class="btn btn-danger" value="Удалить объявление">
      </div>
    </div>
  </div>
</div>
    
</form>
 
    </div>
</div>   


<script>
    
    var users = [];
    
    @forelse($users as $user)
        users[{{$user->id}}] = "{{$user->name}}";
    @empty
    @endforelse
        
    var hint_keywords = users;   console.log(hint_keywords);
    
    $('#author_name').text(hint_keywords[$('#author_name').attr('user_id')]);
    
    // Ід форми пошуку:
    $('#search').on("input", function() {

        // Беру поточне значення:
        var dInput = this.value;

        // Цикл по всіх значеннях масиву:
        $.each( hint_keywords, function(key, value) {

            if (typeof value !== 'undefined') {
                // Якщо є така буква у строці:
                if (value.toLowerCase().indexOf(dInput.trim()) > -1) {

                    // Залишаю
                    $("li[user_name='" + value + "'").show();

                } else {

                    // Якщо букви немає, то приховую цю категорію:
                    $("li[user_name='" + value + "'").hide();

                }
            }
        });

    });

	$('#kw_list').text('');
   
    // Цикл по всіх значеннях масиву:
    $.each( hint_keywords, function(key, value) {
        //console.log(hint_keywords[key]  );
        if (typeof value !== 'undefined') {
            $('#kw_list').append('<li class="search-one-hint" user_name="'+ value +'" hint_name="' + key + '">' + value + '</li>');
        } else {
            
        }
    });
        



	// Відкривашка пошукових підказок:
	$( "#search" ).focus(function() {
		$('#hint_board').fadeIn(200).show();
	});

	// Якщо клік за межами пошуку, приховую:
	$('html').click(function(e) {
	   if(!$(e.target).hasClass('search-hint') && !$(e.target).hasClass('search-one-hint'))
	   {
	       $('#hint_board').fadeOut(100);
	   }
	});
    
	$(function () {

		// Значення атрибута при кліку на нього:
        $('body').on('click', '.search-one-hint', function() {

            var search_field_input = $("#search").val();
            var selected_category = $(this).text();
            var user_id = $(this).attr('hint_name');

            // якщо поле пусте:
            if( search_field_input.length == 0) {
                $("#search").val(selected_category);
            } else {
                // якщо поле не пусте:
                // Перевірити чи є квадратні дужки і слово категорія:
                if(search_field_input.indexOf('[категорія:') + 1) {

                    // Заміняю категорію на нову:
                    var search_parts = search_field_input.split("]");
                    $("#search").val(selected_category);

                } else {

                    // ' + search_field_input + '
                
                    // якщо квадратних дужок немає, то додаю їх:
                    $("#search").val(selected_category);
                }

            }
            
            $('#hint_board').fadeOut(100);
            
            // TODO: change hidden field
            console.log(user_id);
            $('#hidden_user_id_field').val(user_id);
            $('#author_name').text(selected_category);
            $('#author_name').attr('user_id', user_id);

		});

	});
 
    
    
    
    
    
    
    
    
    
    
    
    
    
    
// Клік на об'єкт:
$('body').on('click', '#edit_user', function() {
    
    // Слаг:
    $('#search').show();
    var slug = $('#permalink').attr('slug');
    
    // Очищаю:
    $('#permalink').text('');
    
    // Открываю текстовое поле для ввода нового слага:
    $('#permalink').append('<br>Введите имя или ID пользователя:<br><input type="text" class="form-control" value="' + slug + '" id="new_slug_field" name="new_slug"><br> <span class="btn btn-success" id="save_new_slug">Сохранить автора</span> <span class="btn btn-danger" id="cancel_new_slug">Отмена</span> <span id="error_span"></span><br>');

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
                $('#hidden_user_id_field').val(data.slug);
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

<style>
element {
    display: block !imporant;
}
</style>
@endsection
