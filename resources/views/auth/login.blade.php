<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                        
                    <div class="container" id="container">
                        <div class="form-container sign-up-container">
                            <form method="POST" action="{{ route('register') }}">
                            @csrf
                                <h1>Crear Cuenta</h1>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nombre" />
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Correo" />
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="text" class="form-control @error('cedula') is-invalid @enderror" name="cedula" value="{{ old('cedula') }}" required autocomplete="cedula" placeholder="cedula">
                                @error('cedula')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}" required autocomplete="telefono" placeholder="telefono">
                                @error('telefono')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="text" class="form-control @error('direccion') is-invalid @enderror" name="direccion" value="{{ old('direccion') }}" required autocomplete="direccion" placeholder="direccion">
                                @error('direccion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Contraseña" />
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="password" class="form-control" name="password_confirmation" required autocomplete="new-password"placeholder="Confirmar Contraseña" />
                                <button>Registrar</button>
                            </form>
                        </div>
                        <div class="form-container sign-in-container">
                            <form method="POST" action="{{ route('login') }}">
                            @csrf
                                <h1>Iniciar Sesion</h1>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Correo" />
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña" />
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <a href="{{ route('password.request') }}">Olvidaste tu contraseña?</a>
                                <button>Acceder</button>
                            </form>
                        </div>
                        <div class="overlay-container">
                            <div class="overlay">
                                <div class="overlay-panel overlay-left">
                                    <h1>Bienvenid@ de nuevo!</h1>
                                    <p>Para mantenerse conectado con nosotros, por favor inicie sesión con su información personal</p>
                                    <button class="ghost" id="signIn">Acceder</button>
                                </div>
                                <div class="overlay-panel overlay-right">
                                    <h1>Hola, Amig@!</h1>
                                    <p>Ingrese sus datos personales para comenzar su atención médica con Cliniyork</p>
                                    <button class="ghost" id="signUp">Registrarse</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--<footer>
                        <p>
                            Created with <i class="fa fa-heart"></i> by
                            <a target="_blank" href="https://florin-pop.com">Florin Pop</a>
                            - Read how I created this and how you can join the challenge
                            <a target="_blank" href="https://www.florin-pop.com/blog/2019/03/double-slider-sign-in-up-form/">here</a>.
                        </p>
                    </footer>-->
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Registro exitoso',  
            });
        @endif
    </script>
<script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });
</script>

</body>
</html>
