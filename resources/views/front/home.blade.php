@extends('layouts.app')

@section('content')
<div class="container mt-2">
    <div class="row pt-5">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
<h3 class="mb-4">Личный кабинет пользователя</h3>
                
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Добро пожаловать! Тут будут отображаться ваши объявления. <a href="{{URL::to('/')}}/add_ad">Добавить новое</a>

        </div>
    </div>
</div>
@endsection
