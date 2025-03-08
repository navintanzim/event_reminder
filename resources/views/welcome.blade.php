

@extends('layouts.admin')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
@section('content')

<main class="signup-form">
<div class="container">
<div class="row justify-content-center">
<div class="col-md-5 col-lg-6">
    <div class="signup-content flex-center @if(env('IS_MOBILE') == true) col-lg-start-50 col-md-start-50 col-sm-start-50 @endif" >
        <div class="signup-header">
            <h3>User Access</h3>
        </div>
        <form>
            <div class="signup-body">
          
            <a class="btn btn-primary ebs-login" href="{{ url('/login') }}">Log In</a>
            <a class="btn btn-primary ebs-login" href="{{ route('registration') }}">Register</a>
           
            </div>
        </form>
        
    </div>
</div>
</div>
</div>
</main>
@endsection

