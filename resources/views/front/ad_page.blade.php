@extends('layouts.app')

@section('page_header')Объявление: {{$ad->title}} @endsection

@section('content')
<style>
.company_link { color: #69BEFD; text-decoration: underline; }
.company_link:hover { cursor: pointer;}
.company_logo { width: 30px; float: left; margin-right: 3px;}   
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>	
<script src="http://dagestan.com.yy/adminlte/jquery/dist/jquery.min.js"></script>
<script src="{{ asset('js/rater.js') }}"></script>


<!-- Объявление: --->
<div class="container mt-2">
    <div class="row pt-5">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <h3>{{$ad->title}}</h3>
            <p class="text-secondary">
                <a href="{{URL::to('/')}}">Главная</a> / 
                @if ($ad->type == 1)
                    <a href="{{URL::to('/')}}/company?filter=organizations">Организации</a> / 
                @else
                    <a href="{{URL::to('/')}}/company?filter=specialists">Специалисты</a> / 
                @endif
                @if(count($ad->categories) > 0)
                    
                    @forelse ($ad->categories as $category)
                        <?php if ($ad->type == 1) { ?>
                            <a href="{{URL::to('/')}}/company?categories_ids={{$category->id}}&filter=organizations">{{$category->name}}</a>
                        <?php } else { ?>
                            <a href="{{URL::to('/')}}/company?categories_ids={{$category->id}}&filter=specialists">{{$category->name}}</a>
                        <?php } ?>

                        
                    @empty
                    @endforelse
                @endif
                
                
            <p>
        </div>
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 text-right ">
            <span class="p-2">
            <!-- uSocial -->
                <script async src="https://usocial.pro/usocial/usocial.js?v=6.1.4" data-script="usocial" charset="utf-8"></script>
                <div class="uSocial-Share" data-pid="e98d3bb3a1c420f8b1b2d58d6e4163a6" data-type="share" data-options="rect,style1,default,absolute,horizontal,size24,eachCounter0,counter1,counter-after" data-social="vk,fb,ok,telegram,email,bookmarks" data-mobile="vi,wa,sms"></div>
            <!-- /uSocial -->
            </span>
        </div>
    </div>
</div>



<div class="container mt-3">
    <div class="row">
        <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 ad-map mb-2 bg-light" style="height:400px; overflow: hidden;">
            @if ($ad->img != null)
                <img class="fix-big-image img-fluid mx-auto d-block" src="{{URL::to('/')}}/storage/{{$ad->img}}">
            @else
                <img class="fix-big-image img-fluid mx-auto d-block" src="{{URL::to('/')}}/img/no-image.png">
            @endif
        </div>
        <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 ad-map mb-2">
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

<?php if ($ad->longitude != null and $ad->latitude != null) { ?>
    
    var mymap = L.map('mapid').setView([{{$ad->longitude}}, {{$ad->latitude}}], {{$initZoom}});
<?php } else { ?>
    var mymap = L.map('mapid').setView([{{$max_center[0]}}, {{$max_center[1]}}], {{$initZoom}});
<?php } ?>

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
    
        <div class="text-center">
            <div class="mr-3 ad-tel ad-tel-block float-left">
            <span>
                <span class="hidden_num">
                    <i class="fa fa-phone" aria-hidden="true"></i>
                    <a href="#" class="text-white">Показать номер</a>
                </span> 
            </span>
            </div>
    
        <div class="mr-3 text-center float-left">
            <div class="ad-address ad-address-block">
            <span>
                <i class="fa fa-map-marker" aria-hidden="true"></i> {{$ad->address}}
            </span>
            </div>
        </div>
        <div class="mr-3 text-center float-left">
            <div class="ad-stars ad-stars-block">
            <span>
                <span id="average_stars">{{$ad->stars}}</span> <i class="fa fa-star-o" aria-hidden="true"></i>
            </span>
            </div>
        </div>
        <div class="mr-3 ad-stars-count-block text-center float-left">
            <div class="ad-stars-count text-muted">
            <span>
            @if ($stars == 1) На основе {{$stars}} оценки
            @elseif ($stars > 1 and $stars < 5) На основе {{$stars}} оценок
            @else На основе {{$stars}} оценок
            @endif
            </span>
            </div>
        </div>
        
    </div>
</div>



<div class="container mt-3">
    <div class="row pt-4 pb-3">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 pb-3">
            
            @if($ad->name != null and $ad->surname != null)
            <div class="border-bottom pb-3 pt-3 d-flex justify-content-between">
                <span>Специалист:</span><span class="ad_extend"><span>{{$ad->name}} {{$ad->surname}}</span>
            </div>
            @endif
            
            @if($ad->work_expiriens != null)
            <div class="border-bottom pb-3 pt-3 d-flex justify-content-between">
                <span>Опыт:</span><span class="ad_extend"><span>{{$ad->work_expiriens}} </span>
            </div>
            @endif
            
            <div class="border-bottom pb-3 pt-3 d-flex justify-content-between">
                @if(count($ad->categories) > 0)
                    <span>Категория:</span><span class="ad_extend">
                    @forelse ($ad->categories as $category)
                        <a href="{{URL::to('/')}}/company?categories_ids={{$category->id}}">{{$category->name}}</a>
                    @empty
                    @endforelse
                @endif
                </span>
            </div>
            
            @if($ad->working_hours != null)
            <div class="border-bottom pb-3 pt-3 d-flex justify-content-between">
                <span>Время работы:</span><span class="ad_extend">{{$ad->working_hours}}</span>
            </div>
            @endif
            
            @if($ad->site != null)
            <div class="border-bottom pb-3 pt-3 d-flex justify-content-between">
                <span>Сайт:</span><span class="ad_extend">{{$ad->site}}</span>
            </div>
            @endif
            
            @if($ad->email != null)
            <div class="border-bottom pb-3 pt-3 d-flex justify-content-between">
                <span>E-mail:</span><span class="ad_extend">{{$ad->email}}</span>
            </div>
            @endif
                        
            <div class="border-bottom pb-3 pt-3 d-flex justify-content-between">
                <span>Номер телефона:</span>
                <span class="ad_extend">
                    <span class="hidden_num"><a href="#">Показать</a></span>                
                </span>
            </div>  
            
            @if($ad->average_price != null)
            <div class="border-bottom pb-3 pt-3 d-flex justify-content-between">
                <span>Средняя цена:</span><span class="ad_extend">{{$ad->average_price}}</span>
            </div>
            @endif
            
            @if($ad->vk != null)
            <div class="border-bottom pb-3 pt-3 d-flex justify-content-between">
                <span><i class="fa fa-vk" aria-hidden="true"></i></span><span class="ad_extend">{{$ad->vk}}</span>
            </div>
            @endif
              
            @if($ad->fb != null)
            <div class="border-bottom pb-3 pt-3 d-flex justify-content-between">
                <span><i class="fa fa-facebook" aria-hidden="true"></i></span><span class="ad_extend">{{$ad->fb}}</span>
            </div>
            @endif

            @if($ad->ok != null)
            <div class="border-bottom pb-3 pt-3 d-flex justify-content-between">
                <span><i class="fa fa-odnoklassniki-square" aria-hidden="true"></i></span><span class="ad_extend">{{$ad->ok}}</span>
            </div>
            @endif  

            @if($ad->instagram != null)
            <div class="border-bottom pb-3 pt-3 d-flex justify-content-between">
                <span><i class="fa fa-instagram" aria-hidden="true"></i></span>
                <span class="ad_extend">{{$ad->instagram}}</span>
            </div>
            @endif  
       
       
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

<script>
    $(document).ready(function(){

        var options = {
            max_value: 5,
            step_size: 0.5,
        }
        $(".rating").rate(options);
        
        $(".rating").rate("getValue");
        $(".rating").rate("setValue", 2.5);
        
    });
     
</script>

@if (Auth::check())
<div class="container pb-5 pt-2">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
            <span class="give-star">Оставить оценку:</span> 
            <div class="rating ml-2 pl-4 pr-4 pt-1 pb-1 text-warning ad-stars-rounding" data-rate-value="1"></div>
        </div>
    </div>
</div>
@else
  
@endif

<script>
$(document).ready(function(){

        var options = {
            max_value: 5,
            step_size: 0.5,
        }
        $(".rating").rate(options);
        
        $(".rating").rate("getValue");
        @if ($current_user_star != null)
            $(".rating").rate("setValue", {{$current_user_star->stars}});
        @else
            $(".rating").rate("setValue", 0);
        @endif
    
        $(".rating").on("change", function(ev, data) {
            //console.log(data.from, data.to);
            // Відправляю дані:
            $.ajax({
                type: 'get',
                url: '{{URL::to('/')}}/estimate?ad={{$ad->id}}&stars=' + data.to,
                data: $('#form_id').serialize(),
            })
            .done (function (response) {
               // $(".rating").rate("setValue", data.to);
                //console.log(response);
                $('#average_stars').text(''); // Видаляю вміст блока
                $('#average_stars').append(response.average_stars); // Дописую вміст блока з HTML
            })
            .fail (function () {
                //console.log('form error');
            });
        });

    });



</script>
<!-- /Объявление --->


@endsection
