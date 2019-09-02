@extends('layouts.app')

@section('page_header')Объявление 1 @endsection

@section('content')
<style>
.company_link { color: #69BEFD; text-decoration: underline; }
.company_link:hover { cursor: pointer;}
.company_logo { width: 30px; float: left; margin-right: 3px;}   
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>	
<script src="http://dagestan.com.yy/adminlte/jquery/dist/jquery.min.js"></script>


<!-- Объявление: --->
<div class="container mt-2">
    <div class="row pt-5">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <h3>{{$ad->title}}</h3>
            <p class="text-secondary"><a href="{{URL::to('/')}}">Agargo</a> / <a href="">Салоны</a> / <a href="">Красота</a><p>
        </div>
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 text-right ">
            <span class="p-2 bg-light">Поделиться: [TODO: кнопочки соц.сетей]</span>
        </div>
    </div>
</div>



<div class="container mt-3">
    <div class="row">
        <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 pb-2">
            @if ($ad->img != null)
                <img class="img-fluid mx-auto d-block" src="{{URL::to('/')}}/storage/{{$ad->img}}">
            @else
                <img class="img-fluid mx-auto d-block" src="{{URL::to('/')}}/img/no-image.png">
            @endif
        </div>
        <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 ad-map pb-2">
            <div id="mapid" style="width: 100%; height: 400px; "></div>
        </div>
    </div>
</div>


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
    
<?php if ($ad->longitude != null and $ad->latitude != null) { ?>
    L.marker([{{$ad->longitude}},{{$ad->latitude}}], {icon: greenIcon}).addTo(markerGroup);
<?php } ?>
    
   
     
</script>






<div class="container mt-3 pt-4">
    <div class="row ad-info">
    
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 ad-tel-block text-center">
            <div class="ad-tel">
            <span>
                <span class="hidden_num">
                    <i class="fa fa-phone" aria-hidden="true"></i>
                    <a href="#" class="text-white">Показать номер</a>
                </span> 
            </span>
            </div>
        </div>
        <div class="col-sm-12 col-md-5 col-lg-4 col-xl-4 ad-address-block text-center">
            <div class="ad-address">
            <span>
                <i class="fa fa-map-marker" aria-hidden="true"></i> {{$ad->address}}
            </span>
            </div>
        </div>
        <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2 ad-stars-block text-center">
            <div class="ad-stars">
            <span>
                {{$ad->stars}} <i class="fa fa-star-o" aria-hidden="true"></i>
            </span>
            </div>
        </div>
        <div class="col-sm-6 col-md-2 col-lg-3 col-xl-3 ad-stars-count-block text-center">
            <div class="ad-stars-count text-muted">
            <span>
                46 Оценок
            </span>
            </div>
        </div>
        
    </div>
</div>



<div class="container mt-3">
    <div class="row pt-4 pb-3">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 pb-3">
            <div class="border-bottom pb-3 pt-3 d-flex justify-content-between">
                <span>Категория:</span><span class="ad_extend">Салоны, Красота</span>
            </div>
            <div class="border-bottom pb-3 pt-3 d-flex justify-content-between">
                <span>Время работы:</span><span class="ad_extend">{{$ad->working_hours}}</span>
            </div>
            <div class="border-bottom pb-3 pt-3 d-flex justify-content-between">
                <span>Сайт:</span><span class="ad_extend">{{$ad->site}}</span>
            </div>
            <div class="border-bottom pb-3 pt-3 d-flex justify-content-between">
                <span>E-mail:</span><span class="ad_extend">{{$ad->email}}</span>
            </div>
            <div class="border-bottom pb-3 pt-3 d-flex justify-content-between">
                <span>Номер телефона:</span>
                <span class="ad_extend">
                    <span class="hidden_num"><a href="#">Показать</a></span>                
                </span>
                

                
                </span>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 pb-3">
            <div class="bg-light p-3 rounded">
                {!! $ad->description !!}
            </div>
        </div>
    </div>
</div>

<script>
// Клік на об'єкт:
$('body').on('click', '.hidden_num', function() {
    var phone = '{{$ad->phone}}';
    $('.hidden_num').text('');
    $('.hidden_num').text(phone);
    return false;
});

</script>


<div class="container pb-5 pt-2">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <span class="give-star">Оставить оценку:</spam> 
            <span class="ml-2 pl-4 pr-4 pt-1 pb-1 bg-light text-warning ad-stars-rounding">
            <i class="fa fa-star" aria-hidden="true"></i>
            <i class="fa fa-star" aria-hidden="true"></i>
            <i class="fa fa-star" aria-hidden="true"></i>
            <i class="fa fa-star-half-o" aria-hidden="true"></i>
            <i class="fa fa-star-o" aria-hidden="true"></i>
            </span> 
        </div>
    </div>
</div>

<!-- /Объявление --->


@endsection
