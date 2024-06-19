<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Próximamente Versión 2.0</title>
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css')}}">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #333333;
            transition: opacity 300s, visibility 300s;
            }

            .loader--hidden {
            opacity: 0;
            visibility: hidden;
            }

            .loader::after {
            content: "";
            width: 75px;
            height: 75px;
            border: 15px solid #dddddd;
            border-top-color: #00d2ff;
            border-radius: 50%;
            animation: loading 1s linear infinite;
            }

            @keyframes loading {
            from {
                transform: rotate(0turn);
            }
            to {
                transform: rotate(1turn);
            }
            }

    </style>
</head>
<body class="dark">
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
    <div class="loader">
        <div>
            <h1 style="color: white">Proximamente en la version 2.0....</h1>
        </div>
    </div>
    <script>
        window.addEventListener("load", () => {
            const loader = document.querySelector(".loader");

            loader.classList.add("loader--hidden");

            loader.addEventListener("transitionend", () => {
                document.body.removeChild(loader);
            });
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
