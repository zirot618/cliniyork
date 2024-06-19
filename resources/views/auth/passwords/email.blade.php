<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enlace de restablecimiento</title>
    <link rel="stylesheet" href="{{ asset('assets/email.css') }}">
    <!-- Agregamos SweetAlert2 para las alertas -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <!-- Mostrar la alerta de éxito si existe un mensaje en la sesión -->
                        @if (session('status'))
                             
                            
                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.min.js"></script>
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Correo enviado!',
                                    text: '{{ session('status') }}',
                                    confirmButtonText: 'Cerrar'
                                });
                            </script>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="row mb-3">
                                <div class="instructions">
                                    <h2>¿Olvidaste tu contraseña?</h2>
                                    <p>No te preocupes, ¡recuperarla es fácil!</p>
                                    <ol>
                                        <li>Ingresa tu dirección de correo electrónico asociada con tu cuenta.</li>
                                        <li>Haz clic en "Enviar enlace de restablecimiento".</li>
                                        <li>Revisa tu correo electrónico y sigue el enlace para restablecer tu contraseña.</li>
                                        <li>Crea una nueva contraseña segura y repítela para confirmarla.</li>
                                        <li>Haz clic en "Restablecer contraseña".</li>
                                    </ol>
                                    <p><strong>Consejos:</strong></p>
                                    <ul>
                                        <li>Asegúrate de ingresar la dirección de correo electrónico correcta.</li>
                                        <li>Revisa tu carpeta de spam si no recibes el correo electrónico.</li>
                                        <li>Contacta con nosotros si tienes problemas.</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Ingrese el correo" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Enviar enlace de restablecimiento
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
