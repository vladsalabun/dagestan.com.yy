@extends('cp.cp_head')

@section('page_header')
Карта:
@endsection

@section('content')

<style>
.company_link { color: #69BEFD; text-decoration: underline; }
.company_link:hover { cursor: pointer;}
.company_logo { width: 30px; float: left; margin-right: 3px;}   
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>	
<script src="{{asset('adminlte/jquery/dist/jquery.min.js')}}"></script>

<section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">

        <form method="post" action="{{URL::to('/')}}/cp/post_edit_map_config" autocomplete="off">
        {{ csrf_field() }}
        <p>Центр карты:</p>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-map-pin"></i></span>
    <input type="text" class="form-control" placeholder="longitude" name="longitude" value="{{$longitude}}">
</div>
        <br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-map-pin"></i></span>
    <input type="text" class="form-control" placeholder="latitude" name="latitude" value="{{$latitude}}">
</div>
        <br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-key"></i></span>
    <input type="text" class="form-control" placeholder="GoogleMap API key" name="google_map_key" value="{{$google_map_key}}">
</div>
        <br>
<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-key"></i></span>
    <input type="text" class="form-control" placeholder="OpenStreetMap API key" name="openstreetmap_api_key" value="{{$openstreetmap_api_key}}">
</div>

        <br>
<div class="input-group">
    <input type="submit" name="submit" class="btn btn-success" value="Обновить настройки">
</div>
<br>
<br>
        
        
        
        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">

                
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

    function show_id(company_id) {
        location.href= '{{URL::to("/")}}/edit_nearest_company/' + company_id;
    }   

</script>

        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    

@endsection
