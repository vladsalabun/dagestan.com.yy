@extends('layouts.app')

@section('content')
<div class="container mt-2 border-bottom">
    <div class="row pt-5">

<div class="col-sm-12 col-md-8 col-lg-8 col-xl-9">

<nav aria-label="breadcrumb">
  <ol class="breadcrumb bg-light">
    <li class="breadcrumb-item"><a href="{{URL::to('/')}}/home">Личный кабинет</a></li>
    <li class="breadcrumb-item active" aria-current="page">Изменение пароля:</li>
  </ol>
</nav>


    <h3 class="mb-4">Изменение пароля:</h3>  
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
<!---- ИЗМЕНЕНИЕ ЛИЧНЫХ ДАННЫХ ---->
<form class="form-horizontal" method="POST" action="{{URL::to('/')}}/home">
    {{ csrf_field() }}

<div class="form-group mb-3">
    <input type="text" name="name" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="Имя *" value="{{ Auth::user()->name }}" required>
</div>
<div class="form-group mb-3">
    <input type="text" name="tel" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="Телефон " value="{{ Auth::user()->tel }}" required>
</div>

                        
<div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
    <label for="new-password" class="col-md-4 control-label">Текущий пароль:</label>

    <div class="">
        <input id="current-password" type="password" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" name="current-password" required>

        @if ($errors->has('current-password'))
            <span class="help-block">
                <strong>{{ $errors->first('current-password') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
    <label for="new-password" class="col-md-4 control-label">Новый пароль:</label>

    <div class="">
        <input id="new-password" type="password" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" name="new-password" required>

        @if ($errors->has('new-password'))
            <span class="help-block">
                <strong>{{ $errors->first('new-password') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group">
    <label for="new-password-confirm" class="col-md-4 control-label ">Подтвердите новый пароль:</label>

    <div class="">
        <input id="new-password-confirm" type="password" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" name="new-password_confirmation" required>
    </div>
</div>

<div class="form-group">
    <div class="mt-4">
        <button type="submit" class="btn btn-primary add-button">
            Сохранить изменения
        </button>
    </div>
</div>

</form>
<!---- ИЗМЕНЕНИЕ ЛИЧНЫХ ДАННЫХ ---->
    
    
</div>


    </div>
</div>


</div>
@endsection
