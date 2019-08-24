<nav class="navbar navbar-expand-md bg-white navbar-light">
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
            <a class="nav-link " href="#">Специалисты</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="#">Организации</a>
          </li>
        </ul>
<!-- /Меню слева --->
        
<!-- Меню справа: --->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" id="TownDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <span class="">Ваш город:</span> <span class="text-primary">Махачкала <i class="fa fa-angle-down" aria-hidden="true"></i></span>
                </a>
                
                <!-- Города: --->
                    <div class="dropdown-menu dropdown-towns" aria-labelledby="TownDropdown">

<div class="row">                    
    <div class="col-6">                    
        <div class="m-2 text-center">                    
            <a href="">Хасавюрт</a><br>
            <a href="">Избербаш</a><br>
            <a href="">Акуша</a><br>
            <a href="">Дербент</a><br>
            <a href="">Каспийск</a><br>
        </div>
    </div>
    <div class="col-6">                    
        <div class="m-2 text-center">                    
            <a href="">Хасавюрт</a><br>
            <a href="">Избербаш</a><br>
            <a href="">Акуша</a><br>
            <a href="">Дербент</a><br>
            <a href="">Каспийск</a><br>
        </div>
    </div>
</div>


                    </div>
                 <!-- /Города --->
                
            </li>
            <li class="nav-item">
                <a class="nav-link" href="" data-target="#myModal" data-toggle="modal">Разместить</a>
            </li>
            <li class="nav-item">
                                       <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link text-primary" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <i class="fa fa-angle-down" aria-hidden="true"></i> <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
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


<div class="container-fluid text-center">
<h1 class="pt-5 pb-3">Сервис поиска организаций и услуг</h1>
</div>


<!-- Поиск: ---> 
<div class="container-fluid mt-3 bg-light">
    <div class="row">
        
        
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 p-2">
            <div class="border border-primary bg-white top-search">

<div class="container">
    <div class="row">
        <div class="col-8 p-2">
            <input type="text" class="top-search-form" placeholder="Поиск по организациям и услугам">
        </div>
        <div class="col-2 p-2 top-search-category">
            <a href="" class="top-search-category-link">
                <span class="text-muted">Категории <i class="fa fa-angle-down" aria-hidden="true"></i></span>
            </a>
        
        </div>

            <div class="col-2 p-2 top-search-block text-white text-center bg-primary">
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

    </div>
</div>
<!-- /Поиск ---> 

