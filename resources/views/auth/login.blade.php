@extends('layouts.app')

@section('content')

<div class="container mt-2">
    <div class="row pt-5">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <h3 class="mb-4">Авторизация:</h3>
           <p>Авторизуйтесь, чтобы получить возможность добавлять объявления.</p>
           <p>Поля, отмеченные звездочкой (*), обязательны для заполнения. Правила пользования услугами можно прочитатть <a href="">здесь</a>.</p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

<div class="form-group mb-3">
    <input type="email" name="email" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="e-mail *" value="{{ old('email') }}" required>
@if ($errors->has('email'))
    <span class="help-block">
        <strong>{{ $errors->first('email') }}</strong>
    </span>
@endif
</div>
<div class="form-group mb-3">
    <input type="password" name="password"class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="Пароль *" required>
@if ($errors->has('password'))
    <span class="help-block">
        <strong>{{ $errors->first('password') }}</strong>
    </span>
@endif
</div>
   
<div class="form-group mb-3">
    <input type="submit" class="btn btn-primary add-button" value="Авторизоваться">
</div>
   
<!---
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
---> 
                    </form>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <h3 class="mb-4">Регистрация:</h3>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

<div class="form-group mb-3">
    <input type="text" name="name" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3 @error('name') is-invalid @enderror" placeholder="Имя *" value="{{ old('name') }}" required>
    @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group mb-3">
    <input id="email" type="email"  name="email" value="{{ old('email') }}" autocomplete="email" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3 @error('email') is-invalid @enderror" placeholder="e-mail *" required>
    @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group mb-3">
    <input id="password" type="password" name="password" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3 @error('password') is-invalid @enderror" placeholder="Пароль *" required>
    @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>


<div class="form-group mb-3">
    <input id="password-confirm" type="password" name="password_confirmation" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3 @error('password') is-invalid @enderror" placeholder="Подтверждение пароля *" required>
    @error('password_confirmation')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group mb-3">
    <input type="submit" class="btn btn-primary add-button" value="Зарегистрироваться">
</div>

                    </form>
            
            
        </div>
    </div>
</div>




@endsection
