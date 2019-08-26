@extends('layouts.app')

@section('page_header')Объявления Дагестана@endsection

@section('content')


<div class="container mt-5 mb-5 pb-3">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
            <h3>Рекомендации:</h3>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9 text-right">
            
            <span class="btn btn-light recommendations-buttons text-secondary mb-1">Цена, от</span>
            <span class="btn btn-light recommendations-buttons text-secondary mb-1">Цена, до </span>
            <span class="btn btn-light recommendations-buttons text-secondary mb-1">Сортировать по <i class="fa fa-sort" aria-hidden="true"></i></span>
            <span class="btn btn-light recommendations-buttons text-secondary mb-1" data-toggle="collapse" href="#MapCollapse" role="button" aria-expanded="false" aria-controls="MapCollapse"><i class="fa fa-map" aria-hidden="true"></i> Показать на карте</span>
        </div>
    </div>
</div>





<div class="container mb-5 pb-5">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 mb-3">

<!---- ЛЕВОЕ МЕНЮ: ---->
    <h5 class="text-primary mb-3">Организации:</h6>
     
  <a href="" class="company-link">
    <div class="w-100 pt-2 pb-2 pl-4 pr-4 recommendations-buttons company-link">Лазер</div>
  </a>
  <a href="" class="company-link">
    <div class="w-100 pt-2 pb-2 pl-4 pr-4 recommendations-buttons company-link">Спа</div>
  </a>
  <a href="" class="company-link">
    <div class="w-100 bg-primary text-white pt-2 pb-2 pl-4 pr-4 recommendations-buttons company-link">Другое</div>
  </a>
  
  
     
    <h5 class="text-primary mt-3">Специалисты:</h6>
            
  <a href="" class="company-link">
    <div class="w-100 pt-2 pb-2 pl-4 pr-4 recommendations-buttons company-link">Лазер</div>
  </a>
  <a href="" class="company-link">
    <div class="w-100 pt-2 pb-2 pl-4 pr-4 recommendations-buttons company-link">Спа</div>
  </a>
  <a href="" class="company-link">
    <div class="w-100 pt-2 pb-2 pl-4 pr-4 recommendations-buttons company-link">Другое</div>
  </a>
<!---- /ЛЕВОЕ МЕНЮ ---->    
        </div>
        
    
        
        
        <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">
            
<div class="row">
  <div class="col">
    <div class="collapse multi-collapse" id="MapCollapse">
      <div class="card card-body bg-light text-center ad-map" id="companies_map">
        TODO: Тут будет карта компаний
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





@endsection
