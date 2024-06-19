<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'CliniYork') }}</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css') }}">
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="sidebar close">
    <nav class="sidebar">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="{{ asset('logo.png') }}" alt="Logo">
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
                        <a href="{{ route('dashboard') }}">
                            <i class='bx bx-home-alt icon'></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="{{ route('usuarios.index') }}">
                            <i class='bx bx-user icon'></i>
                            <span class="text nav-text">Usuarios</span>
                        </a>
                    </li>

                    <!-- Agregar más elementos del menú según sea necesario -->

                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-log-out icon'></i>
                            <span class="text nav-text">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bottom-content">
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

    <main class="py-4">
        @yield('content')
    </main>

    <script>
        const body = document.querySelector('body'),
              sidebar = body.querySelector('nav.sidebar'),
              toggle = body.querySelector(".toggle"),
              searchBtn = body.querySelector(".search-box"),
              modeSwitch = body.querySelector(".toggle-switch"),
              modeText = body.querySelector(".mode-text");

        toggle.addEventListener("click" , () => {
            sidebar.classList.toggle("close");
        });

        searchBtn.addEventListener("click" , () => {
            sidebar.classList.remove("close");
        });

        modeSwitch.addEventListener("click" , () => {
            body.classList.toggle("dark");

            if(body.classList.contains("dark")){
                modeText.innerText = "Light mode";
            } else {
                modeText.innerText = "Dark mode";
            }
        });
    </script>
</body>
</html>
