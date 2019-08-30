@extends('cp.cp_head')

@section('page_header')
Города
@endsection

@section('content')
<!-- Страница: --->
<div class="box">
            <div class="box-header">
              <p><a href="{{URL::to('/')}}/cp/add_town" class="btn btn-info">Добавить город</a></p>
            </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
      <table class="table table-striped">
        <tbody>
        <tr>
          <th style="width: 10px">ID:</th>
          <th>Город:</th>
        </tr>
@forelse ($towns as $town)
        <tr>
          <td>{{$town->id}}</td>
          <td><a href="{{URL::to('/')}}/cp/edit_town/{{$town->id}}">{{$town->town}}</a></td>

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
        <div class="text-left"> {{$towns->links('pagination')}}</div>
    </div>
</div>

<!-- /Страница --->

<script>
</script>

@endsection