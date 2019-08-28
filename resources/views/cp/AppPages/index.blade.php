@extends('cp.cp_head')

@section('page_header')
Страницы
@endsection

@section('content')
    
<div class="box">
            <div class="box-header">
              <p><a href="{{URL::to('/')}}/cp/add_page" class="btn btn-info">Добавить страницу</a></p>
            </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
      <table class="table table-striped">
        <tbody>
        <tr>
          <th style="width: 10px">ID:</th>
          <th>Заголовок страницы:</th>
          <th style="width: 50px">Ссылка:</th>
          <th style="width: 100px">Статус:</th>
          <th style="width: 100px">Дата публикации</th>
        </tr>
@forelse ($pages as $page)
        <tr>
          <td>{{$page->id}}</td>
          <td><a href="{{URL::to('/')}}/cp/edit_page/{{$page->id}}">{{$page->title}}</a></td>
          <td><a href="{{URL::to('/')}}/page/{{$page->slug}}" target="_blank"><i class="fa fa-external-link"></i></a></td>
          <td>
              @if ($page->publish_status == 0) Черновик
              @elseif ($page->publish_status == 1) <span class="label label-success">Опубликовано</span>
              @endif
          </td>
          
          <td>{{$page->date}}</td>
        </tr>
@empty
@endforelse
      </tbody>
      </table>
    </div>
    <!-- /.box-body -->
          </div>
    
<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <div class="p-3 pagi-block">
        <div class="text-left"> {{$pages->links('pagination')}}</div>
    </div>
</div>
@endsection
