<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de Citas</title>
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css')}}">

    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <!-- jQuery primero, luego Popper.js, luego Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
            <!--===== Font Awesome ===== -->
            
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
                        <a href="#">
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
    <div class="container mt-3">
        <div class="modal fade" id="addCitaModal" tabindex="-1" aria-labelledby="addCitaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCitaModalLabel">Agendar Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCitaForm" action="{{ route('crear.cita') }}" method="POST">
                    @csrf 
                    <div class="mb-3">
                        <label for="fechaHora" class="form-label">Fecha y Hora:</label>
                        <input type="datetime-local" class="form-control" id="fechaHora" name="fechaHora" required>
                    </div>
                    <div class="mb-3">
                        <label for="motivo" class="form-label">Motivo de la Cita:</label>
                        <select class="form-control" id="motivo" name="motivo" required>
                            <option value="">Seleccione el motivo</option>
                            <option value="Revisión general">Revisión general</option>
                            <option value="Control de enfermedad crónica">Control de enfermedad crónica</option>
                            <option value="Consulta por síntomas específicos">Consulta por síntomas específicos</option>
                            <option value="Vacunas">Vacunas</option>
                            <option value="Otros">Otros</option>
                        </select>
                    </div> 



                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <script>
                        $(document).ready(function() {
                            const user = @json($user);

                            $('#paciente').val(user.name).prop('readonly', true);

                            $.ajax({
                                url: "{{ route('doctores') }}",  // Ruta para obtener los doctores desde el backend
                                type: "GET",
                                dataType: "json",
                                success: function(response) {
                                    populateDoctorDropdown(response);  // Llama a la función para poblar el dropdown de médicos
                                },
                                error: function(error) {
                                    console.error('Error al obtener los doctores:', error);
                                }
                            });

                            function populateDoctorDropdown(doctors) {
                                const doctorDropdown = $('#medico_id');
                                doctorDropdown.empty();  // Vacía las opciones existentes
                                doctorDropdown.append('<option value="">Seleccione un médico</option>');  // Agrega opción por defecto

                                doctors.forEach(doctor => {
                                    const option = $('<option>');  // Crea el elemento opción con jQuery
                                    option.val(doctor.id);  // Asigna el valor del ID del doctor
                                    option.text(doctor.name);  // Asigna el nombre del doctor
                                    doctorDropdown.append(option);  // Agrega la opción al dropdown
                                });
                            }

                            $('#addCitaForm').submit(function(event) {
                                event.preventDefault();  // Evita que se envíe el formulario por defecto

                                // Realiza la petición AJAX para crear la cita
                                $.ajax({
                                    url: "{{ route('crear.cita') }}",
                                    type: "POST",
                                    data: $(this).serialize(),  // Serializa los datos del formulario
                                    dataType: "json",
                                    beforeSend: function(xhr) {
                                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                                    },
                                    success: function(response) {
                                        // Cierra el modal si lo deseas
                                        $('#addCitaModal').modal('hide');

                                        // Muestra una SweetAlert de éxito
                                        Swal.fire({
                                            icon: 'success',
                                            title: '¡Éxito!',
                                            text: response.message  // Mensaje de éxito de la respuesta del servidor
                                        });

                                        // Puedes actualizar la tabla de citas u otras acciones aquí si es necesario

                                        // Opcional: puedes limpiar el formulario después de una creación exitosa
                                        $('#addCitaForm')[0].reset();
                                    },
                                    error: function(error) {
                                        console.error('Error al crear la cita:', error);
                                        alert('Error al crear la cita. Por favor, intenta nuevamente.');
                                    }
                                });
                            });
                        });
                    </script>

                    <div class="mb-3">
                        <label for="medico_id" class="form-label">Médico:</label>
                        <select class="form-select" id="medico_id" name="medico_id" required>
                            <option value="">Seleccione un médico</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="paciente" class="form-label">Paciente:</label>
                        <input type="text" class="form-control" id="paciente" name="paciente_id" readonly>
                    </div>
                    <input type="hidden" id="paciente_id" name="paciente_id" value="{{ $user->id }}">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cita</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editCitaModal" tabindex="-1" aria-labelledby="editCitaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCitaModalLabel">Editar Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCitaForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="fechaHoraEdit" class="form-label">Fecha y Hora:</label>
                        <input type="datetime-local" class="form-control" id="fechaHoraEdit" name="fechaHora" required>
                    </div>
                    <div class="mb-3">
                        <label for="motivoEdit" class="form-label">Motivo de la Cita:</label>
                        <select class="form-control" id="motivoEdit" name="motivo" required>
                            <option value="">Seleccione el motivo</option>
                            <option value="Consulta General">Consulta General</option>
                            <option value="Consulta de seguimiento">Consulta de seguimiento</option>
                            <option value="Consulta de revisión">Consulta de revisión</option>
                            <option value="Consulta de urgencia">Consulta de urgencia</option>
                            <option value="Consulta de interconsulta">Consulta de interconsulta</option>
                            <option value="Consulta de valoración preoperatoria">Consulta de valoración preoperatoria</option>
                            <option value="Consulta de resultados de estudios">Consulta de resultados de estudios</option>
                            <option value="Consulta de procedimiento">Consulta de procedimiento</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="medico_idEdit" class="form-label">Médico:</label>
                        <select class="form-select" id="medico_idEdit" name="medico_id" required>
                            <option value="">Seleccione un médico</option>
                            <!-- Opciones de médicos se llenarán dinámicamente -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="estadoEdit" class="form-label">Estado:</label>
                        <select class="form-control" id="estadoEdit" name="estado" required>
                            <option value="">Seleccione el estado</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="aprobada">Aprobada</option>
                            <option value="finalizada">Finalizada</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>


        

        <div class="container mt-4">
            <div class="row ">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Listado de Citas</h4>
                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addCitaModal">
                            Agendar Cita
                            </button>
                        </div >
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="citasTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Fecha y Hora</th>
                                            <th scope="col">Motivo</th>
                                            <th scope="col">Médico</th>
                                            <th scope="col">Paciente</th>
                                            <th scope="col">Estado</th>
                                            <th scope="col">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Aquí se llenará dinámicamente con los datos de DataTables -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <script>
        $(document).ready(function() {

            $('#citasTable').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('obtenercitas') }}", 
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'fechaHora', name: 'fechaHora' },
                    { data: 'motivo', name: 'motivo' },
                    { data: 'medico_id', name: 'medico_id' },
                    { data: 'paciente_id', name: 'paciente_id' },
                    { data: 'estado', name: 'estado' },
                    {
                        data: null,
                        name: 'acciones',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-primary btn-sm edit-btn" data-id="${row.id}"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="${row.id}"><i class="fa-solid fa-trash"></i></button>
                            `;
                        }
                    }
                ]
            });
        });
    </script>
<script>
$(document).ready(function() {

    // Obtener lista de doctores y poblar el dropdown
    function fetchDoctorsAndPopulateDropdown() {
        $.ajax({
            url: "{{ route('doctores') }}",
            type: "GET",
            dataType: "json",
            success: function(response) {
                populateDoctorDropdown(response);
            },
            error: function(error) {
                console.error('Error al obtener los doctores:', error);
            }
        });
    }

    fetchDoctorsAndPopulateDropdown();

    function populateDoctorDropdown(doctors) {
        const doctorDropdown = $('#medico_id, #medico_idEdit');
        doctorDropdown.empty();
        doctorDropdown.append('<option value="">Seleccione un médico</option>');

        doctors.forEach(doctor => {
            const option = $('<option>');
            option.val(doctor.id);
            option.text(doctor.name);
            doctorDropdown.append(option);
        });
    }

    // Guardar nueva cita
    $('#saveCitaBtn').click(function() {
        $.ajax({
            url: "{{ route('crear.cita') }}",
            type: "POST",
            data: $('#addCitaForm').serialize(),
            dataType: "json",
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function(response) {
                $('#addCitaModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Cita agendada con éxito.'

                }).then(() => {
                    location.reload(); // Recargar la página o tabla de citas si es necesario
                });
                
            },
            error: function(error) {
                console.error('Error al crear la cita:', error);
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Error al crear la cita. Por favor, intenta nuevamente.'
                });
            }
        });
    });

    // Editar cita
    $('#citasTable').on('click', '.edit-btn', function() {
    var citaId = $(this).data('id');
    $.ajax({
        url: `/citas/${citaId}`,
        type: 'GET',
        success: function(data) {
            // Cargar datos en el modal de edición
            $('#editCitaModal').find('#fechaHoraEdit').val(data.cita.fechaHora);
            $('#editCitaModal').find('#motivoEdit').val(data.cita.motivo);
            $('#editCitaModal').find('#medico_idEdit').val(data.cita.medico_id);
            $('#editCitaModal').find('#estadoEdit').val(data.cita.estado); // Asegura que esto esté correcto
            $('#editCitaModal').modal('show');

            // Actualizar cita al enviar el formulario de edición
            $('#editCitaForm').off('submit').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: `/citas/actualizar/${citaId}`,
                    type: 'PUT',
                    data: $(this).serialize(),
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    success: function(response) {
                        $('#editCitaModal').modal('hide');
                        $('#citasTable').DataTable().ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Cita actualizada exitosamente.'
                        }).then(() => {
                            location.reload(); // Recargar la página o tabla de citas si es necesario
                        });
                    },
                    error: function(xhr) {
                        console.error('Error al actualizar la cita:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: 'Error al actualizar la cita.'
                        });
                    }
                });
            });
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'Error al obtener la información de la cita.'
            });
        }
    });
});

    // Eliminar cita
    $('#citasTable').on('click', '.delete-btn', function() {
        var citaId = $(this).data('id');
        
        // Mostrar SweetAlert2 para confirmar la eliminación
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¡Una vez eliminada la cita, deberás agendar una cita nuevamente!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si se confirma la eliminación, realizar la solicitud AJAX
                $.ajax({
                    url: `/citas/eliminar/${citaId}`,
                    type: 'DELETE',
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    success: function(response) {
                        // Recargar la tabla de citas
                        $('#citasTable').DataTable().ajax.reload();

                        // Mostrar SweetAlert2 de éxito
                        Swal.fire(
                            '¡Eliminado!',
                            'La cita ha sido eliminada.',
                            'success'
                        );
                    },
                    error: function(xhr) {
                        console.error('Error al eliminar la cita:', xhr);
                        // Mostrar SweetAlert2 de error
                        Swal.fire(
                            '¡Error!',
                            'Hubo un problema al eliminar la cita.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>

    <script>
        const body = document.querySelector('body'),
            sidebar = body.querySelector('nav'),
            toggle = body.querySelector(".toggle"),
            searchBtn = body.querySelector(".search-box"),
            modeSwitch = body.querySelector(".toggle-switch"),
            modeText = body.querySelector(".mode-text");


            toggle.addEventListener("click" , () =>{
                sidebar.classList.toggle("close");
            })

            searchBtn.addEventListener("click" , () =>{
                sidebar.classList.remove("close");
            })

            modeSwitch.addEventListener("click" , () =>{
                body.classList.toggle("dark");
                
                if(body.classList.contains("dark")){
                    modeText.innerText = "Light mode";
                }else{
                    modeText.innerText = "Dark mode";
                    
                }
            });
    </script>



    
    