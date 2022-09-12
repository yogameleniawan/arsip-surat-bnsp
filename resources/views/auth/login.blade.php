@extends('layouts/auth')
@section('header')
<style>
    #auth #auth-left .auth-logo img {
        height: 6rem;
    }
    #auth #auth-right {
        height: 100%;
        background: url(assets/images/pages/CWheLqKhJEUxB6VKAKxPBvtgIrcd5Xlq8ptbgnZC.png),linear-gradient(90deg,#2d499d,#3f5491);
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
    }
</style>
@endsection
@section('content')
<div id="auth">
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="index.html"><img src="{{ url('assets/images//pages/Oon92liTCVWOj7IUe5LFjSUiiD2UpDaHAma8bPUa.png') }}" alt="Logo"></a>
                </div>
                <h5 >Log in.</h5>
                <form action="{{route('login')}}" method="POST">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" name="email" class="form-control form-control-xl" placeholder="Email">
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" name="password" class="form-control form-control-xl" placeholder="Password">
                    </div>
                    <button class="btn btn-primary btn-block btn-md shadow-lg mt-5">Log in</button>
                </form>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">

            </div>
        </div>
    </div>

</div>
@endsection
@section('footer')

@endsection
