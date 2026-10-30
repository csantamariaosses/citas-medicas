@extends('layouts.app') 
@section('menu')
  @include('menuadmin')
@endsection

@section('content')

    <div class="container">
        <div class="row">
           <div class="col-6">
               Esta es una llamada a la API <b>http://localhost:80/api/infouser</b> con metodo get
               usando un token de seguridad <br><br>
               En forma previa se hace un llamado post a <b>http://localhost:80/api/login</b>
               con parametros email y password el cual retorna un token en caso de exito

           </div>
        </div>   
     
        <div class="row my-3">
            <div class="col-md-4 offset-md-2">  
              <h3>API</h3>  
              <table class="table">
                 <tr><td>Id</td><td>{{ $data['id']}}</td></tr>
                 <tr><td>Name</td><td>{{ $data['name']}}</td></tr>
                 <tr><td>Email</td><td>{{ $data['email']}}</td></tr>
              </table>  
            </div>
        <div>
    </div>
@endsection