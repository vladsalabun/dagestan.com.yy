@extends('layouts.app')

@section('page_header')Объявления Дагестана@endsection

@section('content')

<?php $banner_count = 0 ;?>
<!-- Карусель баннеров: --->
<div class="container-fluid text-center my-3" id="carousel-big">
    <div class="row mx-auto my-auto">
        <div id="recipeCarousel" class="carousel slide w-100" data-ride="carousel">
            <div class="carousel-inner w-100" role="listbox">
                @forelse ($banners as $banner)
                    @if($banner->img != null)
                        <?php $banner_count++; ?>
                    <div class="carousel-item @if($banner_count == 1) active @else @endif">
                        <img class="d-block col-sm-6 col-md-6 col-lg-3 col-xl-3 img-fluid" src="{{URL::to('')}}/storage/{{$banner->img}}">
                    </div>
                    @else
                    <div class="carousel-item">
                        <img class="d-block col-sm-6 col-md-6 col-lg-3 col-xl-3 img-fluid" src="{{URL::to('')}}/img/no-image.png">
                    </div> 
                    @endif
                
                @empty
                @endforelse
            </div>
            <a class="carousel-control-prev" href="#recipeCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#recipeCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>   
</div>



<script src="{{URL::to('/')}}/js/vlad_carousel.js"></script>
<!-- /Карусель баннеров --->

<?php $banner_count = 0 ; ?>
<div id="carouselMini" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">

    @forelse ($banners as $banner)
<?php $banner_count++; ?>
@if($banner->img != null)
<div class="carousel-item @if($banner_count == 1) active @else @endif">
  <img class="d-block col-sm-6 col-md-6 col-lg-3 col-xl-3 img-fluid" src="{{URL::to('')}}/storage/{{$banner->img}}">
</div>
@else
<div class="carousel-item @if($banner_count == 1) active @else @endif">
    <img class="d-block col-sm-6 col-md-6 col-lg-3 col-xl-3 img-fluid" src="{{URL::to('')}}/img/no-image.png">
</div> 
        @endif
    @empty
    @endforelse
    
  </div>
  <a class="carousel-control-prev" href="#carouselMini" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselMini" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>


<!-- Рекомендации: --->
<div class="container mt-5">
    <div class="row pt-5">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6"><h3>Рекомендации для вас:</h3>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 text-right">
            <span class="btn btn-primary recommendations-buttons">Все</span>
            <span class="btn btn-light recommendations-buttons text-secondary">Организации</span>
            <span class="btn btn-light recommendations-buttons text-secondary">Специалисты</span>
        </div>
    </div>
    
    <div class="row pt-5">
 
@forelse ($ads as $ad)
 
    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 pb-5">
        <div class="recommendation-img-wrap bg-light ad-map" style="height:250px;">
            @if ($ad->img != null)
                <img class="img-fluid mx-auto d-block" src="{{URL::to('/')}}/storage/{{$ad->img}}" style="max-height:250px">
            @else
                <img class="img-fluid mx-auto d-block" src="{{URL::to('/')}}/img/no-image.png">
            @endif
            
            <div class="recommendation-on-img">
                <div class="recommendation-on-img-left">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>{{$ad->address}}
                </div>
                <div class="recommendation-on-img-right">
                    4.7 <i class="fa fa-star-o" aria-hidden="true"></i>
                </div>
            </div>
        </div>
        <div class="p-1">
            <p class="pt-3 pb-1 recommendation-link"><a href="{{URL::to('/')}}/ad/{{$ad->id}}">{{$ad->title}}</a></p>
            <?Php echo Str::limit($ad->description, 120);?>
        </div>
    </div>
@empty
@endforelse






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
