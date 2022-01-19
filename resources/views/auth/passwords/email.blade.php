{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Cambio de Contraseña') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Enviar link de restablecimiento') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
<h3>Restablecimiento de contraseña</h3>
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
<form method="POST" action="{{ route('password.email') }}">
    {{ csrf_field() }}
    <div class="form-group has-icon">
        <i class="icon-envelope-o"></i>
        {!! Form::email('email', null, ['class'=>'form-control form-control-lg', 'placeholder'=>'Dirección de correo electrónico', 'require', 'autofocus']) !!}
        @error('email')
        <span class="help-block text-danger">
            {{ $message }}
        </span>
        @enderror 
    </div>
    <a href="#" onclick="mostrarForm('login')">
        <p class="forget-pass">Atrás para iniciar sesión</p>
    </a>  
    <div class="form-group">
        <input type="submit" onclick="notificacion()" class="btn btn-primary btn-lg btn-block" value="Enviar link de restablecimiento">
    </div>
</form>
<script>
    function notificacion(){
        toastr.info('Si tu correo esta registrado recibiras un link de cambio de contraseña, si no lo encuentras en bandeja de entrada, te sugerimos revisar la bandeja de SPAM.');
    }
</script>
