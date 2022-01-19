@extends('app')
@section('content')
<div class="page parallel">
    <div class="d-flex row">
        <div class="col-md-3 white">
            <div class="p-5 mt-5">
                <img src="../../assets/img/basic/logo.png" alt=""/>
            </div>
            <div class="p-5 login-form">
                <h3>Cambio de Contraseña</h3>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group has-icon">
                        <i class="icon-envelope-o"></i>
                        <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Correo electrónico">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group has-icon">
                        <i class="icon-user-secret"></i>
                        <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Contraseña">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group has-icon">
                        <i class="icon-check"></i>
                        <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" required autocomplete="new-password" placeholder="Confirma contraseña">
                    </div>
                    <br>    
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Reset Password">
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-9  height-full blue accent-3 align-self-center text-center" data-bg-repeat="false" data-bg-possition="center"
        style="background: url('../../assets/img/app/bgLogin.jpeg') #FFEFE4; background-position: center center; background-repeat: no-repeat;
    background-size: cover;">
        </div>
    </div>
</div>
@endsection