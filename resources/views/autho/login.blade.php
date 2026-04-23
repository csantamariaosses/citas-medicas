@extends('layouts.app') 

@section('menu')
  @include('menu')
@endsection

@section('content')

    <div class="container">
  
        <div class="row">
        <div class="col-md-4 offset-md-2">  
             <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" autocomplete="off">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required autofocus autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required autocomplete="off">
                        </div>
                        <button type="submit" class="btn btn-primary">Login::</button>
                    </form>
                </div>
              </div>
       
        <div>
    </div>


<script>
window.onload = function() {
    document.getElementById('email').value = ' ';
    document.getElementById('password').value = '      ';
};
</SCRIPT>
@endsection
