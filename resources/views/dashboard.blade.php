<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css')}}">
    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    
    <title>Dashboard - CliniYork</title>
    <style>
        /* Estilos CSS adicionales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .main-content {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Dividir en 2 columnas */
            gap: 20px; /* Espacio entre los gráficos */
            padding: 20px 0; /* Padding arriba y abajo */
        }

        .chart-container {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            height: 500px; /* Altura del contenedor del gráfico */
        }

        .chart-container canvas {
            max-width: 100%;
            height: 100%; /* Para que el canvas ocupe toda la altura del contenedor */
        }

        .section-title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .card {
            background-color: #fff; /* Fondo blanco para la tarjeta */
            border-radius: 8px; /* Borde redondeado */
            box-shadow: 0 4px 8px rgba(0,0,0,0.5); /* Sombra ligera */
            padding: 10px; /* Espaciado interno */
            height: 100%; /* Altura igual al 100% del contenedor principal */
        }

        .card .chart-container {
            height: 460px; /* Altura del contenedor del gráfico dentro de la tarjeta */
        }

        .card canvas {
            max-width: 100%;
            height: 100%; /* Para que el canvas ocupe toda la altura del contenedor */
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

    <div class="container">
        <h1 class="section-title">Gráficos</h1>

        <div class="main-content">
            <div class="card">
                <div class="chart-container">
                    <canvas id="chart1"></canvas>
                </div>
            </div>
            <div class="card">
                <div class="chart-container">
                    <canvas id="chart2"></canvas>
                </div>
            </div>
            <div class="card">
                <div class="chart-container">
                    <canvas id="chart3"></canvas>
                </div>
            </div>
            <div class="card">
                <div class="chart-container">
                    <canvas id="chart4"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Gráfico 1
            fetch('{{ route('grafico1') }}')
                .then(response => response.json())
                .then(data => {
                    const patientsCount = data.patientsCount;
                    const doctorsCount = data.doctorsCount;
                    const adminsCount = data.adminsCount;

                    const pieData1 = {
                        labels: ['Pacientes', 'Médicos', 'Administrativos'],
                        datasets: [{
                            label: 'Cantidad de Usuarios',
                            data: [patientsCount, doctorsCount, adminsCount],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 206, 86, 0.6)',
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                            ],
                            borderWidth: 1
                        }]
                    };

                    const pieOptions1 = {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw.toLocaleString();
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: 'Usuarios divididos por roles'
                                }
                        }
                    };

                    const ctxPie1 = document.getElementById('chart1').getContext('2d');
                    const myPieChart1 = new Chart(ctxPie1, {
                        type: 'pie',
                        data: pieData1,
                        options: pieOptions1
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });

            // Gráfico 2 (Motivos de cita más recurrentes)
            fetch('{{ route('grafico2') }}')
                .then(response => response.json())
                .then(data => {
                    const labels = data.labels;
                    const counts = data.counts;

                    const barData = {
                        labels: labels,
                        datasets: [{
                            label: 'Motivos de cita más recurrentes',
                            data: counts,
                            backgroundColor: labels.map((label, index) => `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.6)`),
                            borderColor: labels.map((label, index) => `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`),
                            borderWidth: 1
                        }]
                    };

                    const barOptions = {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false,
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw.toLocaleString();
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: 'Tipo de consulta mas solicitada'
                                }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    autoSkip: false, // No saltar los ticks
                                    maxRotation: 45, // Rotar etiquetas para que sean legibles
                                    minRotation: 0  // Rotar etiquetas para que sean legibles
                                }
                            },
                            y: {
                                beginAtZero: true
                            }
                            
                        }
                    };

                    const ctx = document.getElementById('chart2').getContext('2d');
                    const myChart = new Chart(ctx, {
                        type: 'bar',
                        data: barData,
                        options: barOptions
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });



                fetch('{{ route('grafico3') }}')
                .then(response => response.json())
                .then(data => {
                    const labels = data.labels;
                    const chartData = data.data;

                    const lineData = {
                        labels: labels,
                        datasets: [{
                            label: 'Citas por Mes',
                            data: chartData,
                            fill: true, 
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2
                        }]
                    };

                    const lineOptions = {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    };

                    const ctxLine = document.getElementById('chart3').getContext('2d');
                    const chart3 = new Chart(ctxLine, {
                        type: 'line',
                        data: lineData,
                        options: lineOptions
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });

                fetch('{{ route('grafico4') }}')
                .then(response => response.json())
                .then(data => {
                    const labels = data.labels;
                    const datasets = data.datasets;

                    const areaData = {
                        labels: labels,
                        datasets: datasets.map(dataset => ({
                            label: dataset.label,
                            data: dataset.data,
                            backgroundColor: dataset.backgroundColor,
                            borderColor: dataset.borderColor,
                            borderWidth: 1,
                            fill: true
                        }))
                    };

                    const areaOptions = {
                        responsive: true,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        stacked: false,
                        plugins: {
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                            },
                            title: {
                                display: true,
                                text: 'Cantidad de citas: Pendientes, Aprobadas, Finalizadas'
                                }
                        },
                        scales: {
                            x: {
                                stacked: false,
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    };

                    const ctxArea = document.getElementById('chart4').getContext('2d');
                    const chart4 = new Chart(ctxArea, {
                        type: 'line',
                        data: areaData,
                        options: areaOptions
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });



            // Resto de tu código JavaScript aquí
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

        });
    </script>
</body>
</html>
