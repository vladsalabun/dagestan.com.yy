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
            
            <span class="btn btn-light recommendations-buttons text-secondary mb-1">Цена, от</span>
            <span class="btn btn-light recommendations-buttons text-secondary mb-1">Цена, до </span>
            <span class="btn btn-light recommendations-buttons text-secondary mb-1">Сортировать по <i class="fa fa-sort" aria-hidden="true"></i></span>
            <a class="btn btn-light recommendations-buttons text-secondary mb-1" data-toggle="collapse" href="#MapCollapse" role="button" aria-expanded="false" aria-controls="MapCollapse">
            <i class="fa fa-map" aria-hidden="true"></i> Показать на карте
            </a>
            
        </div>
    </div>
</div>


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
            <div class="collapse" id="root_menu_{{$tmp}}">
                <a href="" class="company-link">
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

	var mymap = L.map('mapid').setView([{{$max_center[0]}}, {{$max_center[1]}}], {{$initZoom}});

	L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={{$openstreetmap_api_key}}', {
		maxZoom: {{$maxZoom}},
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox.streets'
	}).addTo(mymap);

    // Відправляю дані:
    $.ajax({ type: 'get', url: '{{URL::to("/")}}/api/get_all_ads_markers', })
    .done (function (data) {

        if(data['status'] == '200') {
            $.each(data['items'], function(index, value) {
                    
                 if(value['latitude'] != null && value['longitude'])    {
                     //console.log(value['latitude'] +' - '+ value['longitude']);
                     console.log(value['latitude']);
                     L.marker(
                        [value['longitude'], value['latitude']]
                     ).addTo(mymap).bindPopup('<a href="{{URL::to('/')}}/cp/edit_ads/' + value['id'] + '">#' + value['id'] + '</a> '+ value['title']);
                 }
                 
            });
        }
 
    });
    
    
    
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
            
    
<?php 
    for ($i = 1; $i <= 5; $i++) {
?>   
    <div class="row mb-4">
    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pb-3">
        <img class="img-fluid mx-auto d-block" src="{{URL::to('/')}}/img/company_photo_template.jpg">
    </div>
    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 pb-1">
    
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
             <p class="pb-1 company-page-company-link">
                <a href="{{URL::to('/')}}/ad/1" class="text-dark">Мастерская красоты Французский дворик</a>
             </p>
             </div>
             <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="row">
                    <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9 mb-3">
                        <div class="ad-address-block ad-address text-primary pl-4">
                            <i class="fa fa-map-marker" aria-hidden="true"></i> Махачкала, Поповича 20, ...
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-3">
                        <div class="ad-address-block ad-address text-center text-primary">
                            <span id="stars_1">4.7</span> <i class="fa fa-star-o" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
               
                <p>В салоне красоты Жання всегда найдут, чем побаловать своих клиентов. В салоне вас ждёт большой выбор процедур для волос и тела.</p>
            </div>
        
        </div>
    </div>
    </div>
<?php
    }
?>
    
        


    <div class="row">
        <div class="col-12">
            <span class="w-100 btn btn-light recommendations-buttons text-primary">Показать еще</span>
        </div>
    </div>
      
            
        </div>
    </div>
</div>


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
