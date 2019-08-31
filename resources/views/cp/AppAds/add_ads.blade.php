@extends('cp.cp_head')

@section('page_header')
Добавить объявление:
@endsection

@section('content')
<ol class="breadcrumb">
    <li><a href="{{URL::to('/')}}/cp"><i class="fa fa-dashboard"></i> Главная</a></li>
    <li><a href="{{URL::to('/')}}/cp/pages">Все страницы</a></li>
    <li class="active">Добавить объявление:</li>
</ol>



<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
    
<form method="post" action="{{URL::to('/')}}/cp/post_add_ads" autocomplete="off" enctype="multipart/form-data">
{{ csrf_field() }}

<table class="table table-bordered">
<tbody>
<tr>
    <th>
        <p><input type="text" class="form-control" value="" name="title" placeholder="Заголовок" required></p>
        <p>Автор: 
        <span class="ml-3 mr-3" id="author_name" user_id="{{Auth::user()->id}}" user_name="{{Auth::user()->name}}">
            {{Auth::user()->name}}</span>
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
        <input type="hidden" value="{{Auth::user()->id}}" name="user_id" id="hidden_user_id_field">
    </th>
    <th style="width: 250px">
<div class="form-group">
<p><b>Статус:</b></p>
  <select class="form-control" name="modeartion">
    <option value="1">Опубликовано</option>
    <option value="0">На модерации</option>
  </select>
</div>
    </th>
</tr>
    
<tr>
    <td>
        <textarea name="description" id="company_description" rows="10" cols="30" placeholder="1" data-sample-short="444"></textarea>
        <script>
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace( 'company_description');
        </script>
        <p></p>
        <p><input type="text" class="form-control" value="" name="name" placeholder="Имя"></p>
        <p><input type="text" class="form-control" value="" name="surname" placeholder="Фамилия"></p>
        <p><input type="text" class="form-control" value="" name="working_hours" placeholder="Время работы"></p>
        <p><input type="text" class="form-control" value="" name="work_expiriens" placeholder="Опыт работы"></p>
        <p><input type="text" class="form-control" value="" name="average_price" placeholder="Средняя цена за услуги"></p>
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
    
function onMapClick(e) {

    $("#lat").val(e.latlng.lat.toFixed(8));
    $("#lng").val(e.latlng.lng.toFixed(8));

    markerGroup.clearLayers();
    
    L.marker([e.latlng.lat,e.latlng.lng], {icon: greenIcon}).addTo(markerGroup).on('click', function(e) {
        //console.log(e.latlng);
    });
    
}

mymap.on('click', onMapClick);

// Клік на об'єкт:
$('body').on('click', '.company_link', function() {
    location.href= '{{URL::to("/")}}/edit_nearest_company/' + $(this).attr('company_id');
    return false;
});
    
     
</script>

        <div id="items" style="margin: 10px; ">
        </div>
        <div id="new_coordinates"></div>       
         
    </td>
    <td>
<div class="form-group">
<p><b>Тип объявления:</b></p>
  <select class="form-control" name="type">
    <option value="1">Организация</option>
    <option value="2">Специалист</option>
  </select>
</div>


<div class="form-group">
<p><b>Город:</b></p>
  <select class="form-control" name="type">
@forelse($towns as $town)
<option value="{{$town->id}}">{{$town->town}}</option>
@empty
@endforelse

  </select>
</div>

<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-money"></i></span>
    <input type="text" class="form-control input-sm" value="" name="price" placeholder="цена">
</div>
<br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-fw fa-envelope-o"></i></span>
    <input type="text" class="form-control input-sm" value="" name="email" placeholder="e-mail">
</div>
<br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-fw fa-phone"></i></span>
    <input type="text" class="form-control input-sm" value="" name="phone" placeholder="phone">
</div>
<br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-fw fa-facebook"></i></span>
    <input type="text" class="form-control input-sm" value="" name="fb" placeholder="facebook">
</div>
<br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-fw fa-odnoklassniki"></i></span>
    <input type="text" class="form-control input-sm" value="" name="ok" placeholder="odnoklassniki">
</div>
<br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-fw fa-vk"></i></span>
    <input type="text" class="form-control input-sm" value="" name="vk" placeholder="vk">
</div> 
<br>    
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-fw fa-instagram"></i></span>
    <input type="text" class="form-control" value="" placeholder="instagram" name="instagram">
</div>
<br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-fw  fa-external-link"></i></span>
    <input type="text" class="form-control" value="" placeholder="site" name="site">
</div>
<br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-fw fa-home"></i></span>
    <input type="text" class="form-control" value="" placeholder="address" name="address">
</div>
        <br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-map-pin"></i></span>
    <input type="text" class="form-control" id="lng" placeholder="longitude" name="longitude" value="">
</div>
        <br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-map-pin"></i></span>
    <input type="text" class="form-control" id="lat" placeholder="latitude" name="latitude" value="">
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


    </td>
</tr>

<tr>
    <td></td>
    <td>
        <input type="submit" name="submit" class="btn btn-success" value="Добавить объявление">
    </td>
</tr>
    
    </tbody>
</table>
        
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

@endsection
