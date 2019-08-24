@extends('layouts.app')

@section('page_header')Объявления Дагестана@endsection

@section('content')

<!-- Карусель баннеров: --->
<div class="container-fluid">
    <div id="carouselExample" class="carousel slide" data-ride="carousel" data-interval="9000">
        <div class="carousel-inner row w-100 mx-auto" role="listbox">
        
<div class="carousel-item col-md-3 active">
    <img class="img-fluid mx-auto d-block" src="{{URL::to('/')}}/img/banner_template1.jpg" alt="slide 1">
</div>
<?php 
    for ($i = 2; $i <= 6; $i++) {
?>   
<div class="carousel-item col-md-3">
    <img class="img-fluid mx-auto d-block" src="{{URL::to('/')}}/img/banner_template<?php echo $i; ?>.jpg" alt="slide <?php echo $i; ?>">
</div>
<?php
    }
?>
        </div>
        <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
            <i class="fa fa-arrow-circle-o-left top_carousel_icons" aria-hidden="true"></i>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next text-faded" href="#carouselExample" role="button" data-slide="next">
            <i class="fa fa-arrow-circle-o-right top_carousel_icons" aria-hidden="true"></i>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>
<script src="{{ asset('js/vlad_carousel.js') }}"></script>
<!-- /Карусель баннеров --->








<!-- Рекомендации: --->
<div class="container mt-5">
    <div class="row pt-5">
        <div class="col-6"><h3>Рекомендации для вас:</h3>
        </div>
        <div class="col-6 text-right">
            <span class="btn btn-primary recommendations-buttons">Все</span>
            <span class="btn btn-light recommendations-buttons text-secondary">Организации</span>
            <span class="btn btn-light recommendations-buttons text-secondary">Специалисты</span>
        </div>
    </div>
    
    <div class="row pt-5">
<?php 
    for ($i = 1; $i <= 6; $i++) {
?>   
    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 pb-5">
        <div class="p-1 recommendation-img-wrap">
            <img class="img-fluid mx-auto d-block" src="{{URL::to('/')}}/img/company_photo_template.jpg">
            <div class="recommendation-on-img">
                <div class="recommendation-on-img-left">
                    <i class="fa fa-map-marker" aria-hidden="true"></i> Махачкала, Поповича 20, ...
                </div>
                <div class="recommendation-on-img-right">
                    4.7 <i class="fa fa-star-o" aria-hidden="true"></i>
                </div>
            </div>
        </div>
        <div class="p-1">
            <p class="pt-3 pb-1 recommendation-link"><a href="{{URL::to('/')}}/ad/1">Мастерская красоты Французский дворик</a></p>
            <p>В салоне красоты Жання всегда найдут, чем побаловать своих клиентов. В салоне вас ждёт большой выбор процедур для волос и тела.</p>
        </div>
    </div>
<?php
    }
?>
    </div>
</div>
<!-- /Рекомендации --->
<div class="container mb-5 pb-5">
    <div class="row">
        <div class="col-12">
            <span class="w-100 btn btn-light recommendations-buttons text-primary">Показать еще</span>
        </div>
    </div>
</div>

@endsection
