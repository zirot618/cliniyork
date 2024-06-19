<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido a Cliniyork</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #ecf0f1; 
            background-image: url('{{ asset('images/waves-background.png') }}'); 
            background-size: cover;
            background-repeat: repeat-x;
            color: #333333; 
            text-align: center;
            margin: 0;
            padding-bottom: 100px; /* Ajuste para el footer */
        }
        .header {
            background-color: rgba(0, 61, 114, 0.8); 
            padding: 2rem;
            margin-bottom: 2rem;
            position: relative; /* Para ajustar el botón de login */
        }
        .header h1 {
            font-size: 3rem;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 1rem;
        }
        .header p {
            font-size: 1.5rem;
            color: #ffffff;
        }
        .carousel-item img {
            max-height: 400px;
            object-fit: cover;
            width: 100%;
        }
        
        .content {
            background-color: rgba(255, 255, 255, 0.9); 
            padding: 20px;
            margin: 20px auto;
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .content p {
            font-size: 1.2rem;
            line-height: 1.6;
        }
        .footer {
            background-color: rgba(0, 61, 114, 0.8); 
            color: #ffffff;
            padding: 1rem 0;
            width: 100%;
            position: absolute;
            bottom: 0;
            left: 0;
        }
        .login-button {
            display: inline-block;
            background: linear-gradient(to bottom, #0072b5, #004080); 
            color: #ffffff;
            font-size: 1rem;
            font-weight: bold;
            padding: 12px 24px; 
            text-decoration: none;
            border-radius: 20px; 
            right: 2rem; /* Ajuste para el botón de login */
            top: 2rem; /* Ajuste para el botón de login */
            transition: background 0.3s ease;
            border: 2px solid #ffffff; 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
            position: absolute;
        }
        .login-button:hover {
            background: linear-gradient(to bottom, #005aa7, #002a46); 
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bienvenido a Cliniyork</h1>
        <p>Una Clínica al alcance de todos.</p>
        <a href="{{ route('login') }}" class="login-button">Iniciar sesión</a>
    </div>
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/slide1.jpg') }}" class="d-block w-100" alt="Slide 1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/slide2.jpg') }}" class="d-block w-100" alt="Slide 2">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/slide3.jpg') }}" class="d-block w-100" alt="Slide 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="content">
        <!-- Contenido dinámico -->
    </div>
    <footer class="footer py-4 bg-dark text-white">
        <div class="container text-center">
            <p>&copy; {{ date('Y') }} Cliniyork. Todos los derechos reservados PAMYSEBA-SA.</p>
        </div>
    </footer>

    <!-- Bootstrap JS y otros scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
