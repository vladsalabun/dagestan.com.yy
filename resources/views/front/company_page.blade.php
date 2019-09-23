@extends('layouts.app')

@section('page_header')Объявления Дагестана@endsection

@section('content')
<style>
.company_link { color: #69BEFD; text-decoration: underline; }
.company_link:hover { cursor: pointer;}
.company_logo { width: 30px; float: left; margin-right: 3px;}   
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>	


<div class="container mt-5 mb-5 pb-3">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
            <h3>Рекомендации:</h3>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9 text-right">
            
            <span class="btn btn-light recommendations-buttons text-secondary mb-1 mr-2 pr-3 pl-3" data-toggle="modal" data-target="#priceModal">Вилка цены</span>
            <span class="btn btn-light recommendations-buttons text-secondary mb-1 mr-2 pr-3 pl-3" data-toggle="modal" data-target="#sortModal">Сортировать по <i class="fa fa-sort" aria-hidden="true"></i></span>
            <a class="btn btn-light recommendations-buttons text-secondary mb-1 mr-2 pr-3 pl-3" data-toggle="collapse" href="#MapCollapse" role="button" aria-expanded="false" aria-controls="MapCollapse">
            <i class="fa fa-map" aria-hidden="true"></i> Показать на карте
            </a>
            
        </div>
    </div>
</div>



<!-- Вилка цены: -->
<div class="modal fade" id="priceModal" tabindex="-1" role="dialog" aria-labelledby="priceModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="priceModalLabel">Укажите диапазон цены:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
 <div class="form-group">
    <label for="exampleInputEmail1">Цена от:</label>
    <input type="number" step="100" class="form-control" id="form_price_from" value="{{Request::get('price_from')}}">
  </div>
 <div class="form-group">
    <label for="exampleInputEmail1">Цена до:</label>
    <input type="number" step="100" class="form-control" id="form_price_to" value="{{Request::get('price_to')}}">
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
        <button type="button" class="btn btn-success" id="save_fork">Сохранить</button>
      </div>
    </div>
  </div>
</div>


<!-- Сортировка -->
<div class="modal fade" id="sortModal" tabindex="-1" role="dialog" aria-labelledby="sortModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sortModalLabel">Укажите параметры сортировки объявлений:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
<div class="form-check">
  <input class="form-check-input" type="radio" name="form_sort_date" id="form_sort_date0" value="" checked>
  <label class="form-check-label" for="form_sort_date0">
    Не сортировать по дате
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="form_sort_date" id="form_sort_date1" value="asc" @if(Request::get('sort_date') == 'asc') checked @endif>
  <label class="form-check-label" for="form_sort_date1">
    Дата, от старых к новым
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="form_sort_date" id="form_sort_date2" value="desc" @if(Request::get('sort_date') == 'desc') checked @endif>
  <label class="form-check-label" for="form_sort_date2">
    Дата, от новых к старым
  </label>
</div>

<hr>
<div class="form-check">
  <input class="form-check-input" type="radio" name="form_sort_price" id="form_sort_price0" value="" checked>
  <label class="form-check-label" for="form_sort_price0">
    Не сортировать по цене
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="form_sort_price" id="form_sort_price1" value="asc" @if(Request::get('sort_price') == 'asc') checked @endif>
  <label class="form-check-label" for="form_sort_price1">
    Цена, от дешевых к дорогим
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="radio" name="form_sort_price" id="form_sort_price2" value="desc" @if(Request::get('sort_price') == 'desc') checked @endif>
  <label class="form-check-label" for="form_sort_price2">
    Цена, от дорогих к дешевым
  </label>
</div>




      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
        <button type="button" class="btn btn-success" id="save_sorting">Сохранить</button>
      </div>
    </div>
  </div>
</div>


<script>
// Клік на об'єкт:
$('body').on('click', '#save_fork', function() {
    
    var form_price_from = $('#form_price_from').val();
    var form_price_to = $('#form_price_to').val();
    
    $('#price_from').val(form_price_from);
    $('#price_to').val(form_price_to);
    
    $('#priceModal').modal('hide');
    $('.top-search-block').toggleClass('bg-primary bg-info');
    
    return false;
});

// Клік на об'єкт:
$('body').on('click', '#save_sorting', function() {
    
    var form_sort_date = $('input[name=form_sort_date]:checked').val(); 
    var form_sort_price = $('input[name=form_sort_price]:checked').val();
    var form_type = $('input[name=form_type]:checked').val();
    
    $('#sort_date').val(form_sort_date);
    $('#sort_price').val(form_sort_price);
    $('#type').val(form_type);
    
    $('#sortModal').modal('hide');
    $('.top-search-block').toggleClass('bg-primary bg-info');
    
    return false;
    
});



</script>




<div class="container mb-5 pb-5">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-3">

<!---- ЛЕВОЕ МЕНЮ: ---->
<?php 
    if(is_array($categories_tree)) {
        
        $tmp = 0;
        
        foreach ($categories_tree as $name => $sub_array) {
            $tmp++;
?>
        <a href="#root_menu_{{$tmp}}" plus_id="{{$tmp}}" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="root_menu_{{$tmp}}" class="root_menu_a">
            <div class="d-flex justify-content-between">
                <h5 class="text-primary mb-3">{{$name}}</h6>
                <span class="p-1" id="plus_id_{{$tmp}}"><i class="fa fa-plus" aria-hidden="true"></i></span>
            </div>
        </a>
<?php 
        foreach ($sub_array as $sub_id => $sub_name) { 
?> 
            <div class="collapse <?php if($name === $parent_category_to_expand) {echo 'show';} ?>" id="root_menu_{{$tmp}}">
                <a href="{{URL::to('/')}}/company?categories_ids={{$sub_id}}<?php 
          $filter = Request::input('filter');
                    if($filter == 'specialists') {
                        echo '&filter=specialists';
                    }
                    if($filter == 'organizations') {
                        echo '&filter=organizations';
                    }
                
?>" class="company-link">
                    <div class="w-100 mb-1 pt-2 pb-2 pl-4 pr-4 recommendations-buttons company-link">{{$sub_name}}</div>
                </a>
            </div>
<?php
        }
?>

<?php
        }
    }
?>
    

<!---- /ЛЕВОЕ МЕНЮ ---->    
        </div>
        
    
        
        
        <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">
            
<div class="row">
  <div class="col">
    <div class="collapse multi-collapse" id="MapCollapse">
      <div class="card card-body bg-light text-center ad-map" id="companies_map">
                <div id="mapid" style="width: 100%; height: 400px; "></div>
<script>

	var mymap = L.map('mapid').setView([{{$max_center[1]}}, {{$max_center[0]}}], {{$initZoom}});

	L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={{$openstreetmap_api_key}}', {
		maxZoom: {{$maxZoom}},
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox.streets'
	}).addTo(mymap);

    
<?php

    foreach ($markers as $marker) {
        
        if($marker['img'] != null) {
            $tmp_marker_popup = '<img src="'.URL::to('/').'/storage/'.$marker['img'].'" style="width: 100px;"><br><a href="'.URL::to('/').'/ad/'.$marker['id'].'">'.$marker['title'].'</a><br>'.$marker['address'];
        } else {
            $tmp_marker_popup = '<a href="'.URL::to('/').'/ad/'.$marker['id'].'">'.$marker['title'].'</a><br>'.$marker['address'];
        }

        
        echo "L.marker([".$marker['longitude'].", ".$marker['latitude']."]).addTo(mymap).bindPopup('".$tmp_marker_popup."'); ";
    }
    
?>
    
    /*
    // Відправляю дані:
    $.ajax({ type: 'get', url: '{{URL::to("/")}}/api/get_all_ads_markers', })
    .done (function (data) {

        if(data['status'] == '200') {
            $.each(data['items'], function(index, value) {
                    
                 if(value['latitude'] != null && value['longitude'])    {
                     //console.log(value['latitude'] +' - '+ value['longitude']);
                     //console.log(value['latitude']);
                     L.marker(
                        [value['longitude'], value['latitude']]
                     ).addTo(mymap).bindPopup('<a href="{{URL::to('/')}}/cp/edit_ads/' + value['id'] + '">#' + value['id'] + '</a> '+ value['title']);
                 }
                 
            });
        }
 
    });
    */
    
    
/*
    function show_id(company_id) {
        location.href= '{{URL::to("/")}}/edit_nearest_company/' + company_id;
    }   
*/
 

$('#MapCollapse').on('shown.bs.collapse', function () {
    // do something…
    mymap.invalidateSize();
})
</script>

      </div>
    </div>
  </div>
</div> 




<div id="get_more">     
<!--- Объявления: --->
@forelse ($ads as $ad)
    <div class="row mb-4">
    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pb-3 ">
        <div class="recommendation-img-wrap bg-light ad-map" style="height:200px; overflow: hidden;">
            @if($ad->img != null)
                <img class="img-fluid mx-auto d-block fix-image" src="{{URL::to('/')}}/storage/{{$ad->img}}">
            @else
                <img class="img-fluid mx-auto d-block fix-image" src="{{URL::to('/')}}/img/no-image.png">
            @endif
        </div>
    </div>
    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 pb-1">
    

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
             <p class="pb-1 company-page-company-link">
                <a href="{{URL::to('/')}}/ad/{{$ad->id}}" class="text-dark">{{$ad->title}}</a>
             </p>
             </div>
             <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
                    <div class="company-address-left pt-2 pb-2 pr-4">
                        <i class="fa fa-map-marker pl-2 pr-2" aria-hidden="true"></i> {{$ad->address}}
                    </div>
                    <div class="company-address-right pt-2 pb-2 pl-4 pr-4">
                    {{$ad->stars}} <i class="fa fa-star-o" aria-hidden="true"></i>
                    </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <?php echo Str::limit($ad->description, 120);?>
            </div>
        
        </div>

    
    </div>
    </div>
@empty
<div class="row">
<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
<p>По выбранным критериям объявлений нет.</p>
</div>
</div>
@endforelse
<!--- /Объявления ---> 
</div>        


    <div class="row">
        <div class="col-12">
            <span class="w-100 btn btn-light recommendations-buttons text-primary get_more" next_page="2">Показать еще</span>
        </div>
    </div>
      
            
        </div>
    </div>
</div>



<script>
// Клік на об'єкт:
$('body').on('click', '.get_more', function() {
    
    var filter = '{{$filter}}'; 
    
    if(filter.length != 0) {
    
        var next_page = $('.get_more').attr('next_page'); console.log(next_page);
        
        var c = $('#categories_search_field').val();
        var s = $('#search_text').val();
        var f = $('#price_from').val();
        var to = $('#price_to').val();
        var d = $('#sort_date').val();
        var p = $('#sort_price').val();
        var t = $('#type').val();
        var fi = $('#filter').val();

        console.log('categories_ids='+c+'&search='+s+'&price_from='+f+'&price_to='+to+'&sort_date='+d+'&sort_price='+p+'&filter='+fi+'&page=' + next_page);
        
        // Відправляю дані:
        $.ajax({
            type: 'get',
            url: '{{URL::to('/')}}/api/get_more?categories_ids='+c+'&search='+s+'&price_from='+f+'&price_to='+to+'&sort_date='+d+'&sort_price='+p+'&filter='+fi+'&page=' + next_page,
        })
        .done (function (data) {

            if(data.status == 200) {
               
               $.each(data.items, function(index, value) {

                    $('#get_more').append('<div class="row mb-4"><div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pb-3"><div class="recommendation-img-wrap bg-light ad-map" style="height:200px; overflow: hidden;"><img class="img-fluid img-fluid mx-auto d-block" src="' + value.img + '"></div></div><div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 pb-1"><div class="row"><div class="col-sm-12 col-md-12 col-lg-12 col-xl-12"><p class="pb-1 company-page-company-link"><a href="{{URL::to('/')}}/ad/' + value.id + '" class="text-dark">' + value.title + '</a></p></div><div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3"><div class="company-address-left pt-2 pb-2 pr-4"><i class="fa fa-map-marker fa fa-map-marker pl-2 pr-2" aria-hidden="true"></i> ' + value.address + '</div><div class="company-address-right pt-2 pb-2 pl-4 pr-4">' + value.stars + ' <i class="fa fa-star-o" aria-hidden="true"></i></div></div><div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">' + value.description + '</div></div></div></div>')
               });
                                
                
                // Следующая страница
                next_page = parseInt(next_page) + 1;
                $('.get_more').attr('next_page', next_page);
                console.log('next_page: ' + next_page);
                
            } else {
                $('.get_more').remove();
            }
        })
        .fail (function () {
            //console.log('form error');
        });
    } else {
        
        var next_page = $('.get_more').attr('next_page'); 
        
        var c = $('#categories_search_field').val();
        var s = $('#search_text').val();
        var f = $('#price_from').val();
        var t = $('#price_to').val();
        var d = $('#sort_date').val();
        var p = $('#sort_price').val();
        var t = $('#type').val();


        // Відправляю дані:
        $.ajax({
            type: 'get',
            url: '{{URL::to('/')}}/api/get_more?filter='+filter+'&page='+next_page,
        })
        .done (function (data) {

            if(data.status == 200) {
               
               $.each(data.items, function(index, value) {

                    $('#get_more').append('<div class="row mb-4"><div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pb-3"><div class="recommendation-img-wrap bg-light ad-map" style="height:200px; overflow: hidden;"><img class="img-fluid img-fluid mx-auto d-block" src="' + value.img + '"></div></div><div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 pb-1"><div class="row"><div class="col-sm-12 col-md-12 col-lg-12 col-xl-12"><p class="pb-1 company-page-company-link"><a href="{{URL::to('/')}}/ad/' + value.id + '" class="text-dark">' + value.title + '</a></p></div><div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3"><div class="company-address-left pt-2 pb-2 pr-4"><i class="fa fa-map-marker fa fa-map-marker pl-2 pr-2" aria-hidden="true"></i> ' + value.address + '</div><div class="company-address-right pt-2 pb-2 pl-4 pr-4">' + value.stars + ' <i class="fa fa-star-o" aria-hidden="true"></i></div></div><div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">' + value.description + '</div></div></div></div>')
               });
                                
                
                // Следующая страница
                next_page = parseInt(next_page) + 1;
                $('.get_more').attr('next_page', next_page);
                console.log('next_page: ' + next_page);
                
            } else {
                $('.get_more').remove();
            }
        })
        .fail (function () {
            //console.log('form error');
        });
    }
    
    return false;
});

</script>











<script>
$('body').on('click', '.root_menu_a', function() {
    var plus_id = $(this).attr('plus_id');

    $('#root_menu_' + plus_id).on('show.bs.collapse', function () {
      // do something...
      $('#plus_id_' + plus_id).text('');
      $('#plus_id_' + plus_id).append('<i class="fa fa-minus" aria-hidden="true"></i>');
    })
    $('#root_menu_' + plus_id).on('hide.bs.collapse', function () {
      // do something...
      $('#plus_id_' + plus_id).text('');
      $('#plus_id_' + plus_id).append('<i class="fa fa-plus" aria-hidden="true"></i>');
    })
    
});
</script>


@endsection
