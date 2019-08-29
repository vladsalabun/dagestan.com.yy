@extends('layouts.app')

@section('content')
<div class="container mt-2 border-bottom">
    <div class="row pt-5">

<div class="col-sm-12 col-md-8 col-lg-8 col-xl-9">
    <h3 class="mb-4">{{ Auth::user()->name }}</h3>
    <p>
        {{ Auth::user()->email }}<br>
        {{ Auth::user()->tel }}
    </p>
    <p class="text-muted">На сайте с {{ Auth::user()->created_at }}</p>
</div>

<div class="col-sm-12 col-md-4 col-lg-4 col-xl-3 pb-3">
<a href="{{URL::to('/')}}/home/edit" class="btn btn-primary add-button">Изменить личные данные</a>
</div>

    </div>
</div>


<div class="container mt-2 border-bottom">
    <div class="row pt-5">
        <div class="col-sm-12 col-md-8 col-lg-8 col-xl-9">
            <h3 class="mb-4">Мои объявления:</h3>  
        </div>
    </div>
    
    
<?php 
    for ($i = 1; $i <= 5; $i++) {
?>   
    <div class="row mb-4 border-bottom pb-4">
  
    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-9">
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
                                4.7 <i class="fa fa-star-o" aria-hidden="true"></i>
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
    </div>
    
    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3">
        <a href="{{URL::to('/')}}/edit_ad/1" class="btn btn-primary add-button">Изменить объявление</a>
    </div>
    
    
    </div>
<?php
    }
?>
    

<div class="col-sm-12 col-md-4 col-lg-4 col-xl-3 pb-3">

</div>

    </div>
</div>
@endsection
