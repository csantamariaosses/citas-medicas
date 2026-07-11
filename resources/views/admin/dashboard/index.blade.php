@extends('layouts.app') 

@section('menu')
  @include('menuadmin')
@endsection

@section('content')
    <h3>DASHBOARD</h3>

    <div class="row">
        <div class="col-8">
              <div class="card">
                    <div class="card-header">
                          DASHBOARD
                    </div>
                    <div class="card-body">
                           <SPAN>BODY DASHBOAR</SPAN>
                           
                    </div>
                </div>
        </div>
    </div>

@endsection