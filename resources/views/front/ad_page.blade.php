@extends('layouts.app')

@section('page_header')Объявление 1 @endsection

@section('content')



<!-- Объявление: --->
<div class="container mt-2">
    <div class="row pt-5">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <h3>Мастерская красоты SHOW:</h3>
            <p class="text-secondary"><a href="{{URL::to('/')}}">Agargo</a> / <a href="">Салоны</a> / <a href="">Красота</a><p>
        </div>
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 text-right ">
            <span class="p-2 bg-light">Поделиться: [TODO: кнопочки соц.сетей]</span>
        </div>
    </div>
</div>

<div class="container mt-3">
    <div class="row">
        <div class="col-7">
            <img class="img-fluid mx-auto d-block" src="{{URL::to('/')}}/img/d.jpg">
        </div>
        <div class="col-5 bg-light text-center ad-map">
            TODO: Карта
        </div>
    </div>
</div>

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
                <i class="fa fa-map-marker" aria-hidden="true"></i> Махачкала, Поповича 20, 1 этаж
            </span>
            </div>
        </div>
        <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2 ad-stars-block text-center">
            <div class="ad-stars">
            <span>
                4.7 <i class="fa fa-star-o" aria-hidden="true"></i>
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
                <span>Время работы:</span><span class="ad_extend">Ежедневно: 09:00 - 20:00</span>
            </div>
            <div class="border-bottom pb-3 pt-3 d-flex justify-content-between">
                <span>Сайт:</span><span class="ad_extend">janna-bs.ru</span>
            </div>
            <div class="border-bottom pb-3 pt-3 d-flex justify-content-between">
                <span>E-mail:</span><span class="ad_extend">info@janna-bs.ru</span>
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
                <p>В салоне красоты Жання всегда найдут, чем побаловать своих клиентов. В салоне вас ждёт большой выбор процедур для волос и тела. Опытные косметологи помогут вам вновь засиять от счастья.</p>
                <p>Поработать с формой ногтей, убрать отросшую кутикулу, привести в порядок ногтевую пластину и по желанию клиента — нанести краску.</p>
            </div>
        </div>
    </div>
</div>

<script>
// Клік на об'єкт:
$('body').on('click', '.hidden_num', function() {
    var phone = '+7 (928) 999 000';
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
