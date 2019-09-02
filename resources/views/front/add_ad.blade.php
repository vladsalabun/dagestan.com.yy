@extends('layouts.app')

@section('page_header')Добавить объявление @endsection

@section('content')



<!-- Добавление объявления: --->
<div class="container mt-2">
    <div class="row pt-5">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
@if (Auth::check())
    <h3 class="mb-4">Добавить объявление:</h3>

<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="organization-tab" data-toggle="tab" href="#organization" role="tab" aria-controls="organization" aria-selected="true">Организация</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="specialist-tab" data-toggle="tab" href="#specialist" role="tab" aria-controls="specialist" aria-selected="false">Специалист</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">


<!-- ФОРМА ДОБАВЛЕНИЯ ОРГАНИЗАЦИИ: --->
<div class="tab-pane fade show active mt-5" id="organization" role="tabpanel" aria-labelledby="organization-tab">

    <form method="post" action="{{URL::to('/')}}/post_add_ad" autocomplete="off" id="" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="1">


<div class="form-group mb-3">
    <input type="text" name="title" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="Название организации *" required>
</div>
<div class="form-group mb-3 form-town-block">
    <select class="form-control agagro-form-style towns-selection pt-2 pb-2 pl-3 pr-1" name="town_id" required></select>
</div>
<div class="form-group mb-3">
    <input type="text" name="address" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="Адрес *" required>
</div>
<div class="form-group mb-3">
    <input type="text" name="phone" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="Телефон *" required>
</div>
<div class="form-group mb-3">
    <input type="text" name="email" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="e-mail">
</div>
<div class="form-group mb-3">
    <input type="text" name="working_hours" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="График работы *" required>
</div>

    
    <!-- Родительская категория: --->
<div class="form-group mb-3 form-root-category-selection">
    <select class="form-control agagro-form-style root-category-selection pt-2 pb-2 pl-3 pr-1" id="root1" name="root_category" required></select>
</div>
    <!-- Дочерняя категория: --->
<div class="form-group mb-3 root1-form-sub-category-selection">
    <select class="form-control agagro-form-style sub-category-selection pt-2 pb-2 pl-3 pr-1" id="child1" name="sub_category" required></select>
</div>

<div class="form-group mb-4">
    <label for="exampleFormControlTextarea1">Кратко об организации *:</label>
    <textarea class="form-control agagro-form-style-textarea" name="description" rows="3" required></textarea>
</div>

    <!-- Соц. сети: --->
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
        
<div class="form-group mb-3">
    <input type="text" name="instagram" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="Instagram">
</div>
<div class="form-group mb-3">
    <input type="text" name="fb" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="Facebook">
</div>

        
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
        
<div class="form-group mb-3">
    <input type="text" name="vk" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="VK">
</div>
<div class="form-group mb-3">
    <input type="text" name="ok" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="OK">
</div>
      
        </div>
    </div>
</div>
    <!-- /Соц. сети --->

<div class="form-group mb-3">
    <label for="exampleFormControlFile1">Фотография:</label>
    <div class="agagro-form-style pt-2 pb-2 pl-3 pr-3">
        <input type="file" name="img" class="form-control-file" id="exampleFormControlFile1">
    </div>
</div>


<div class="form-check mb-3 oferta-block">
  <input class="form-check-input" type="checkbox" value="1" id="oferta-check1" name="oferta" required>
  <label class="form-check-label" for="oferta">
    Ознакомлен с <a href="">публичной офертой</a> и <a href="">политикой в области обработки персональных данных</a>, все условия принимаю
  </label>
</div>

    <div class="form-group mb-3">
        <input type="submit" name="submit" class="btn btn-primary add-button" id="submit_organization" value="Разместить">
    </div>

    </form>

</div>
<!-- /ФОРМА ДОБАВЛЕНИЯ ОРГАНИЗАЦИИ --->
  
  
  
  
  
  
  
  
<!-- ФОРМА ДОБАВЛЕНИЯ СПЕЦИАЛИСТА: --->
<div class="tab-pane fade mt-5" id="specialist" role="tabpanel" aria-labelledby="specialist-tab">

    <form method="post" action="{{URL::to('/')}}/post_add_ad" autocomplete="off" id="">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="2">


<div class="form-group mb-3">
    <input type="text" name="title" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="Заголовок *" required>
</div>


    <!-- ФиО: --->
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
        
<div class="form-group mb-3">
    <input type="text" name="name" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="Имя *" required>
</div>

        
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
        
<div class="form-group mb-3">
    <input type="text" name="surname" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="Фамилия *" required>
</div>
      
        </div>
    </div>
</div>
    <!-- /ФиО --->




<div class="form-group mb-3 form-town-block">
    <select class="form-control agagro-form-style towns-selection pt-2 pb-2 pl-3 pr-1" name="town_id" required></select>
</div>
<div class="form-group mb-3">
    <input type="text" name="address" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="Адрес *" required>
</div>
<div class="form-group mb-3">
    <input type="text" name="phone" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="Телефон *" required>
</div>
<div class="form-group mb-3">
    <input type="text" name="email" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="e-mail">
</div>
<div class="form-group mb-3">
    <input type="text" name="working_hours" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="График работы *" required>
</div>
<div class="form-group mb-3">
    <input type="text" name="work_expiriens" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="Опыт работы">
</div>
<div class="form-group mb-3">
    <input type="text" name="average_price" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="Средняя цена за услуги">
</div>
    
    
    
    <!-- Родительская категория: --->
<div class="form-group mb-3 form-root-category-selection">
    <select class="form-control agagro-form-style root-category-selection pt-2 pb-2 pl-3 pr-1" id="root2" name="root_category" required></select>
</div>
    <!-- Дочерняя категория: --->
<div class="form-group mb-3 root2-form-sub-category-selection">
    <select class="form-control agagro-form-style sub-category-selection pt-2 pb-2 pl-3 pr-1" id="child2" name="sub_category" required></select>
</div>

<div class="form-group mb-4">
    <label for="exampleFormControlTextarea1">Кратко об организации *:</label>
    <textarea class="form-control agagro-form-style-textarea" rows="3" name="description" required></textarea>
</div>

    <!-- Соц. сети: --->
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
        
<div class="form-group mb-3">
    <input type="text" name="instagram" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="Instagram">
</div>
<div class="form-group mb-3">
    <input type="text" name="fb" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="Facebook">
</div>

        
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
        
<div class="form-group mb-3">
    <input type="text" name="vk" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="VK">
</div>
<div class="form-group mb-3">
    <input type="text" name="ok" class="form-control agagro-form-style pt-2 pb-2 pl-3 pr-3" placeholder="OK">
</div>
      
        </div>
    </div>
</div>
    <!-- /Соц. сети --->

<div class="form-group mb-3">
    <label for="exampleFormControlFile1">Фотография:</label>
    <div class="agagro-form-style pt-2 pb-2 pl-3 pr-3">
        <input type="file" name="img" class="form-control-file" id="exampleFormControlFile1">
    </div>
</div>


<div class="form-check mb-3 oferta-block">
  <input class="form-check-input" type="checkbox" value="1" id="oferta-check2" name="oferta" required>
  <label class="form-check-label" for="oferta">
    Ознакомлен с <a href="">публичной офертой</a> и <a href="">политикой в области обработки персональных данных</a>, все условия принимаю
  </label>
</div>

    <div class="form-group mb-3">
        <input type="submit" name="submit" class="btn btn-primary add-button" id="submit_specialist" value="Разместить">
        
    </div>

    </form>

</div>
<!-- /ФОРМА ДОБАВЛЕНИЯ СПЕЦИАЛИСТА --->


</div>



@else

@endif    

        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
           <p>Поля, отмеченные звездочкой (*), обязательны для заполнения.</p>
           <p>Правила пользования услугами можно прочитатть <a href="">здесь</a>.</p>
        </div>
    </div>
</div>

<!-- /Добавление объявления --->


<script>
// Відправляю дані:
$.ajax({
    type: 'get',
    url: '{{URL::to('/')}}/api/get_towns',
})
.done (function (data) {
    console.log('Городов: ' +data.items.length);
    
    $('.towns-selection').text(''); 
    
    $('.towns-selection').append('<option value="">-- Выберите город * --</option>');
    
    if(data.items.length > 0) {
        // show town selection:
        $.each(data.items, function(index, value) {
            $('.towns-selection').append('<option value="' + value.id + '">' + value.town + '</option>');
        });
    } else {
        // hide town field:
        $('.towns-selection').hide();
        $('.form-town-block').append('Ошибка! В базе данных нет городов. Обязательно сообщите об этом администратору!');
    }

})
.fail (function () {
    //console.log('form error');
});

// Відправляю дані:
$.ajax({
    type: 'get',
    url: '{{URL::to('/')}}/api/get_root_categories',
})
.done (function (data) {
    //console.log('Родительских категорий: ' + data.items.length);

    $('.root-category-selection').text(''); 
    
    $('.root-category-selection').append('<option value="">-- Выберите категорию * --</option>');
    
    if(data.items.length > 0) {
        // show town selection:
        $.each(data.items, function(index, value) {
            $('.root-category-selection').append('<option value="' + value.id + '">' + value.name + '</option>');
        });
    } else {
        // hide town field:
        $('.root-category-selection').hide();
        $('.form-root-category-selection').text('Ошибка! Категории недоступны. Обновите страницу и, если снова увидите это сообщение, напишите администратору сайта.');
    }

})
.fail (function () {
    //console.log('form error');
});



$('.sub-category-selection').hide(); 

$('.root-category-selection').change(function(){
    
    var root_id = $(this).attr('id'); 
    
    if(root_id == 'root1') {
        var child_id = 'child1'; 
    } else if (root_id == 'root2') {
        var child_id = 'child2'; 
    }

    var selected_root = $( "#" + root_id + " option:selected" ).val();
    
    if(selected_root > 0) {
        
        $('#' + child_id).show();
        $('#error-' + root_id + '-form-sub-category-selection').remove('');       

        // Відправляю дані:
        $.ajax({
            type: 'get',
            url: '{{URL::to('/')}}/api/get_sub_categories?id='+ selected_root,
        })
        .done (function (data) {
            console.log('Дочерних категорий: ' + data.items.length);
            //console.log(data.items);

            $('#' + child_id).text(''); 
            $('#' + child_id).append('<option value="">-- Выберите подкатегорию * --</option>');
            
            if(data.items.length > 0) {
                // show town selection:
                $.each(data.items, function(index, value) {
                    $('#' + child_id).append('<option value="' + value.id + '">' + value.name + '</option>'); 
                });
            } else {
                // hide town field:
                $('#' + child_id).hide(); 
                
                //$('.' + root_id + '-form-sub-category-selection').text('');
                $('.' + root_id + '-form-sub-category-selection').append('<span id="error-' + root_id + '-form-sub-category-selection">Ошибка! В этой категории нет подкатегорий, поэтому сюда добавить объявлений нельзя. Выберите другую категорию.</span>');
            }

        })
        .fail (function () {
            //console.log('form error');
        });
        
    } else {
        $('#' + child_id).hide();
        $('#error-' + root_id + '-form-sub-category-selection').remove(''); 
    }
    
    
});


// Проверка заполнения полей со звездочками перед отправкой
$('body').on('click', '#submit_organization', function() {
    
    if($('#oferta-check1').is(":checked") == true) {
        return true;
    } else {
        $('.oferta-block').addClass('border border-danger pt-2 pb-2 pl-5 pr-5 rounded bg-light');
        return false;
    }
    
});
$('body').on('click', '#submit_specialist', function() {
    
    if($('#oferta-check2').is(":checked") == true) {
        return true;
    } else {
        $('.oferta-block').addClass('border border-danger pt-2 pb-2 pl-5 pr-5 rounded bg-light');
        return false;
    }
    
});
     
     
     

</script>

@endsection
