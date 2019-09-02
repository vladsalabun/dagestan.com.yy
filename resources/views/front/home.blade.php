@extends('layouts.app')

@section('content')
<div class="container mt-2 border-bottom">
    <div class="row pt-5">

<div class="col-sm-12 col-md-8 col-lg-8 col-xl-9">
    <h3 class="mb-4">{{ Auth::user()->name }} @if (Auth::user()->is_ban == 1) <span class="text-danger">(заблокирован)</span> @endif</h3>
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
    
@forelse ($ads as $ad)

    <div class="row mb-4 border-bottom pb-4">
  
    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-9">
        <div class="row mb-4">
        <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pb-3">
            @if ($ad->img != null)
                <img class="img-fluid mx-auto d-block" src="{{URL::to('/')}}/storage/{{$ad->img}}">
            @else
                <img class="img-fluid mx-auto d-block" src="{{URL::to('/')}}/img/no-image.png">
            @endif
        </div>
        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 pb-1">
        
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                 <p class="pb-1 company-page-company-link">
                    <a href="{{URL::to('/')}}/ad/{{$ad->id}}" class="text-dark">{{$ad->title}}</a>
                 </p>
                 </div>
                 <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="row">
                        <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9 mb-3">
                            <div class="ad-address-block ad-address text-primary pl-4">
                                <i class="fa fa-map-marker" aria-hidden="true"></i> {{$ad->address}}
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-3">
                            <div class="ad-address-block ad-address text-center text-primary">
                                {{$ad->stars}} <i class="fa fa-star-o" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                   
                    {!! $ad->description !!}
                </div>
            
            </div>
        </div>
        </div>
    </div>
    
    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3">
        <a href="{{URL::to('/')}}/edit_ad/{{$ad->id}}" class="btn btn-primary add-button">Изменить объявление</a>
    </div>
    
    
    </div>

@empty  
@endforelse  

<div class="col-sm-12 col-md-4 col-lg-4 col-xl-3 pb-3">

</div>

    </div>
</div>
@endsection
