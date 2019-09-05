<nav class="navbar navbar-expand-lg bg-white navbar-light">
<div class="container">

<!-- Главная: -->
    <b><a class="navbar-brand abs " href="{{URL::to('/')}}">Agargo</a></b>
<!-- /Главная -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse" id="collapsingNavbar">
       
<!-- Меню слева: --->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link " href="{{URL::to('/')}}/company?filter=organizations">Специалисты</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{URL::to('/')}}/company?filter=specialists">Организации</a>
          </li>
        </ul>
<!-- /Меню слева --->
        
<!-- Меню справа: --->
        <ul class="navbar-nav ml-auto">
        
            <li class="nav-item">
                <a class="nav-link" href="{{URL::to('/')}}/add_ad">
                <span class="border border-primary pt-1 pb-1 pl-3 pr-3 add-button text-primary">
                    <i class="fa fa-plus" aria-hidden="true"></i> Разместить
                </span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" id="TownDropdown" data-toggle="collapse" href="#TownCollapse" role="button" aria-expanded="false" aria-controls="TownCollapse">
                <span class="">Ваш город:</span> 

@forelse ($towns as $town)
    @if ($town->id == $favourite_town)
        <span class="text-primary">
            <span class="underline-dotted">{{$town->town}}</span> <i class="fa fa-angle-down" aria-hidden="true"></i>
        </span>
    @endif
@empty
@endforelse
                    
                </a>
                               
            </li>
            <li class="nav-item">
                                       <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-lock" aria-hidden="true"></i> Войти</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link text-primary" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <i class="fa fa-angle-down" aria-hidden="true"></i> <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    
                                    @if(Auth::user()->role_id == 1) 
                                        <a class="dropdown-item" href="{{ URL::to('/') }}/cp"><i class="fa fa-cog" aria-hidden="true"></i> Панель управления</a>
                                    @endif
                                    <a class="dropdown-item" href="{{ URL::to('/') }}/home"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Личный кабинет</a>
                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                        
            </li>
        </ul>
<!-- /Меню справа --->

    </div>
</div>
</nav>


<!-- Города: --->
<div class="container border-0">
    <div class="row">
        <div class="col">
            <div class="collapse multi-collapse" id="TownCollapse">
                <div class="row">
@forelse ($towns as $town)
<div class="col-4 text-center"><a href="{{URL::to('/')}}/town/{{$town->id}}" class="underline-dotted no-underline">{{$town->town}}</a></div> 
@empty
@endforelse
                </div>
            </div>
        </div>
    </div> 
</div> 
<!-- /Города --->

<div class="container-fluid text-center">
<h1 class="pt-5 pb-3">Сервис поиска организаций и услуг</h1>
</div>



<form method="get" action="{{URL::to('/')}}/company" autocomplete="off" id="top-search-ajax">
{{ csrf_field() }}
<input type="hidden" name="categories_ids" value="{{$categories_ids}}" id="categories_search_field">
<input type="hidden" name="price_from" value="{{Request::get('price_from')}}" id="price_from">
<input type="hidden" name="price_to" value="{{Request::get('price_to')}}" id="price_to">
<input type="hidden" name="sort_date" value="{{Request::get('sort_date')}}" id="sort_date">
<input type="hidden" name="sort_price" value="{{Request::get('sort_price')}}" id="sort_price">
<input type="hidden" name="type" value="{{Request::get('type')}}" id="type">
<!-- Поиск: ---> 
<div class="container-fluid mt-3 bg-light">
    <div class="row">
        
        
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 p-2">
            <div class="border border-primary bg-white top-search">

<div class="container">
    <div class="row">
        <div class="col-5 col-md-8 col-lg-8 col-xl-8 p-2">
            <input type="text" class="top-search-form" placeholder="Поиск услуг" id="search_text" value="{{$search_text}}">
        </div>
        <div class="col-4 col-md-2 col-lg-2 col-xl-2 p-2 top-search-category">
            <span class="text-muted top-search-category-link" data-toggle="collapse" href="#CategoryCollapse" role="button" aria-expanded="false" aria-controls="CategoryCollapse">
            Категории 
            <i class="fa fa-angle-down" aria-hidden="true"></i>
            </span>

        </div>

        <div class="col-3 col-md-2 col-lg-2 col-xl-2 p-2 top-search-block text-white text-center bg-primary">
            <a href="" class="top-search-button">       
                Найти 
                <i class="fa fa-search" aria-hidden="true"></i>
            </a>
        </div>
        

    </div>
</div>
     
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col">
        
        <div class="pb-2" id="keywords_block">
@forelse ($all_categories as $cat)
<?php 
    if (in_array($cat->id,$categories_ids_array)) {
?>
<span class="badge badge-info pointer" id="selected-category-{{$cat->id}}" cat_id="{{$cat->id}}">{{$cat->name}}</span>
<?php    
    }
?>
@empty
@endforelse

        </div>
        
            <div class="collapse multi-collapse" id="CategoryCollapse">
                <div class="p-3">
<div class="row">
@forelse ($all_categories as $cat)
<?php 
    if($cat->parent_id != 0) {
    if (in_array($cat->id,$categories_ids_array)) {
?>
<div class="col-4 text-center"><span class="underline-dotted no-underline pointer selected-category-for-search" cat_id="{{$cat->id}}" id="category-{{$cat->id}}">{{$cat->name}}</span></div>  
<?php    
    } else {
?>
<div class="col-4 text-center"><span class="underline-dotted no-underline pointer category-for-search" cat_id="{{$cat->id}}" id="category-{{$cat->id}}">{{$cat->name}}</span></div>  
<?php    
    }
    }
?>
@empty
@endforelse
</div>
                </div>
            </div>
        </div>
    </div> 
</div> 

<script>

// Клік на об'єкт:
$('body').on('click', '.category-for-search', function() {
    var cat_id = $(this).attr('cat_id');
    $('#keywords_block').append(' <span class="badge badge-info pointer" id="selected-category-' + cat_id + '" cat_id="' + cat_id + '">' + $(this).text() + '</span> ');
    
    $(this).toggleClass('category-for-search selected-category-for-search');
    
    
    var old_cats = $('#categories_search_field').val();

    if (old_cats.length == 0) {
        $('#categories_search_field').val(cat_id);
    } else {
        var cats_array = $('#categories_search_field').val().split(',');
        cats_array.push(cat_id);
        $('#categories_search_field').val(cats_array.toString());
    }

    return false;
});

// Клік на об'єкт:
$('body').on('click', '.selected-category-for-search', function() {
    var cat_id = $(this).attr('cat_id');

    $('#selected-category-' + cat_id).remove();
    $(this).toggleClass('selected-category-for-search category-for-search');
    
    var old_cats = $('#categories_search_field').val();

    if (old_cats.length == 0) {
        
    } else {
        var cats_array = $('#categories_search_field').val().split(',');

        for( var i = 0; i < cats_array.length; i++){ 
           if ( cats_array[i] === cat_id) {
             cats_array.splice(i, 1); 
           }
        }
        
        $('#categories_search_field').val(cats_array.toString());
    }
    
    return false;
});



// Перехід до пошуку:
$('body').on('click', '.top-search-button', function() {
    
    var selected_cats = $('#categories_search_field').val();
    var search_text = $('#search_text').val();
    var price_from = $('#price_from').val();
    var price_to = $('#price_to').val();
    var sort_date = $('#sort_date').val();
    var sort_price = $('#sort_price').val();
    var type = $('#type').val();
    
    window.location.replace("{{URL::to('/')}}/company?categories_ids=" + selected_cats + "&search=" + search_text + '&price_from=' + price_from + '&price_to=' + price_to + '&sort_date=' + sort_date + '&sort_price=' + sort_price + '&type=' + type);

    return false;
});
</script>




    </div>
</div>
<!-- /Поиск ---> 
</form>

