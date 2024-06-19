<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Citas</title>
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <!-- Estilos personalizados -->
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .card {
            max-width: 1000px; /* Ajustar el ancho máximo de la tarjeta */
            margin: 0 auto; /* Centrar la tarjeta en la página */
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }
        .fc-event {
            background-color: #007bff; /* Color llamativo para eventos */
            border-color: #007bff;
            color: #fff;
        }
        .fc-daygrid-event {
            padding: 2px 5px;
        }
    </style>
</head>
<body class="dark public-background">
<nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="logo.png" alt="">
                </span>

                <div class="text logo-text">
                    <span class="name">CliniYork</span>
                    
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">

                <li class="search-box">
                    <i class='bx bx-search icon'></i>
                    <input type="text" placeholder="Search...">
                </li>

                <ul class="menu-links">
                <li class="nav-link">
                        <a href="/dashboard">
                            <i class='bx bx-home-alt icon' ></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="/usuarios">
                            <i class='bx bx-user icon' ></i>
                            <span class="text nav-text">Usuarios</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="/citas">
                            <i class='bx bx-health icon'></i>
                            <span class="text nav-text">Citas</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="/historialmedico">
                            <i class='bx bx-book-heart icon'></i>
                            <span class="text nav-text">Historial</span>
                        </a>
                    </li> 

                    <li class="nav-link">
                        <a href="/calendario">
                            <i class='bx bx-calendar-heart icon' ></i>
                            <span class="text nav-text">Calendario</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="/facturas">
                            <i class='bx bx-wallet icon' ></i>
                            <span class="text nav-text">Facturacion</span>
                        </a>
                    </li>

                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class='bx bx-log-out icon' ></i>
                        <span class="text nav-text">Logout</span>
                    </a>

                    <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                        @csrf
                    </form>
                </li>

                <li class="mode">
                    <div class="sun-moon">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
                    </div>
                    <span class="mode-text text">Dark mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
                
            </div>
        </div>

    </nav>
    <div class="container">
        <div class="card">
            <h1>Calendario de Citas</h1>
            <div id="calendar"></div>
        </div>
    </div>

    <!-- Scripts necesarios -->
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Vista inicial: mes
                locale: 'es', // Configurar idioma español (opcional)
                events: function(info, successCallback, failureCallback) {
                    // Aquí se deberá realizar una solicitud AJAX para obtener las citas
                    fetch('{{ route('citascalendario') }}') // Ruta para obtener citas (nuevo método)
                        .then(response => response.json())
                        .then(data => {
                            successCallback(data); // Pasar los eventos al calendario
                        })
                        .catch(error => {
                            console.error('Error al cargar citas:', error);
                            failureCallback(error);
                        });
                }
            });
        
            calendar.render(); // Renderizar el calendario
        });


        const body = document.querySelector('body'),
                sidebar = body.querySelector('nav'),
                toggle = body.querySelector(".toggle"),
                searchBtn = body.querySelector(".search-box"),
                modeSwitch = body.querySelector(".toggle-switch"),
                modeText = body.querySelector(".mode-text");

            toggle.addEventListener("click" , () =>{
                sidebar.classList.toggle("close");
            });

            searchBtn.addEventListener("click" , () =>{
                sidebar.classList.remove("close");
            });

            modeSwitch.addEventListener("click" , () =>{
                body.classList.toggle("dark");
                
                if(body.classList.contains("dark")){
                    modeText.innerText = "Modo Claro";
                }else{
                    modeText.innerText = "Modo Oscuro";
                    
                }
            });

        
    </script>
</body>
</html>
