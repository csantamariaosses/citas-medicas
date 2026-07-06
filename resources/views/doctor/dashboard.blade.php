@extends('layouts.app')

@section('menu')
  @include('menudoctor')  
@endsection

@section('content')
<style>
    .color-green {
        color: #008000;
    }
    .color-red {
        color: #ff0000;
    }
    .color-blue {
        color: #0000ff;
    }
</style>
    <div class="row">
        <div class="col-10 offset-2">  
          <h3>Doctor Dashboard</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-10 offset-2">  
     Nombre:{{ session('doctorName') }} - Role: {{ session('role') }} - Id:{{ session('user_id') }} - Email:{{ session('user_email') }}
        </div>
    </div>

    <div class="row">
        <div class="col-8 offset-2">  
            <h3>DASHBOARD</h3>
        </div>
    </div>

@endsection


