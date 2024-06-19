<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Historial Clínico</title>
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css')}}">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
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

<!-- Modal para agregar historial médico -->
<div class="modal fade" id="addHistorialModal" tabindex="-1" aria-labelledby="addHistorialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addHistorialModalLabel">Agregar Historial Médico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addHistorialForm">
                <div class="modal-body">
                    <label for="paciente_id" class="form-label">Médico:</label>
                        <select class="form-select" id="paciente_id" name="paciente_id" required>
                            <option value="">Seleccione un médico</option>
                        </select>
                    <div class="mb-3">
                        <label for="fechaInicio" class="form-label">Fecha de Inicio</label>
                        <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" required>
                    </div>
                    <div class="mb-3">
                        <label for="fechaFin" class="form-label">Fecha de Fin</label>
                        <input type="date" class="form-control" id="fechaFin" name="fechaFin" >
                    </div>
                    <div class="mb-3">
                        <label for="antecedentes_medicos" class="form-label">Antecedentes Médicos</label>
                        <textarea class="form-control" id="antecedentes_medicos" name="antecedentes_medicos" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="historial_medicamentos" class="form-label">Historial de Medicamentos</label>
                        <textarea class="form-control" id="historial_medicamentos" name="historial_medicamentos" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para editar historial médico -->
<div class="modal fade" id="editHistorialModal" tabindex="-1" aria-labelledby="editHistorialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editHistorialModalLabel">Editar Historial Médico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editHistorialForm" >
                <div class="modal-body">
                    <input type="hidden" id="edit_historial_id" name="id">
                    <div class="mb-3">
                        <label for="edit_paciente_id" class="form-label">Paciente:</label>
                        <select class="form-select" id="edit_paciente_id" name="paciente_id" required>
                            <option value="">Seleccione un paciente</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_fechaInicio" class="form-label">Fecha de Inicio</label>
                        <input type="date" class="form-control" id="edit_fechaInicio" name="fechaInicio" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_fechaFin" class="form-label">Fecha de Fin</label>
                        <input type="date" class="form-control" id="edit_fechaFin" name="fechaFin">
                    </div>
                    <div class="mb-3">
                        <label for="edit_antecedentes_medicos" class="form-label">Antecedentes Médicos</label>
                        <textarea class="form-control" id="edit_antecedentes_medicos" name="antecedentes_medicos" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_historial_medicamentos" class="form-label">Historial de Medicamentos</label>
                        <textarea class="form-control" id="edit_historial_medicamentos" name="historial_medicamentos" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Historial Médico</h4>
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addHistorialModal">
                            Agregar Registro
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="historial-table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Paciente</th>
                                        <th scope="col">Fecha Inicio</th>
                                        <th scope="col">Fecha Fin</th>
                                        <th scope="col">Antecedentes médicos</th>
                                        <th scope="col">Historial de medicamentos</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>


<script>
$(document).ready(function() {
    // Cargar pacientes y poblar el dropdown
    function fetchPatientsAndPopulateDropdown() {
        $.ajax({
            url: "{{ route('pacientes') }}",
            type: "GET",
            dataType: "json",
            success: function(response) {
                populatePatientDropdown(response);
            },
            error: function(error) {
                console.error('Error al obtener los pacientes:', error);
            }
        });
    }

    // Poblar el dropdown de pacientes
    function populatePatientDropdown(patients) {
        const patientDropdown = $('#paciente_id, #edit_paciente_id');
        patientDropdown.empty();
        patientDropdown.append('<option value="">Seleccione un paciente</option>');
        patients.forEach(patient => {
            const option = $('<option>');
            option.val(patient.id);
            option.text(patient.name);
            patientDropdown.append(option);
        });
    }

    // Cargar pacientes al cargar la página
    fetchPatientsAndPopulateDropdown();

    // Crear historial
    $('#addHistorialForm').submit(function(event) {
        event.preventDefault();
        $.ajax({
            url: "{{ route('crear.historial') }}",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function(response) {
                $('#addHistorialModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: response.message
                });
                $('#addHistorialForm')[0].reset();
                $('#historial-table').DataTable().ajax.reload();
            },
            error: function(error) {
                console.error('Error al crear el registro en el historial:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al crear el registro en el historial. Por favor, intente de nuevo.'
                });
            }
        });
    });

    // Abrir modal de edición y cargar datos
    $(document).on('click', '.edit-btn', function() {
        const historialId = $(this).data('id');
        $.ajax({
            url: `/historiales/${historialId}`,
            type: "GET",
            dataType: "json",
            success: function(response) {
                if(response) {
                    $('#edit_historial_id').val(response.id);
                    $('#edit_paciente_id').val(response.paciente_id);
                    $('#edit_fechaInicio').val(response.fechaInicio);
                    $('#edit_fechaFin').val(response.fechaFin);
                    $('#edit_antecedentes_medicos').val(response.antecedentes_medicos);
                    $('#edit_historial_medicamentos').val(response.historial_medicamentos);
                    $('#editHistorialModal').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se encontraron los datos del historial.'
                    });
                }
            },
            error: function(error) {
                console.error('Error al obtener los datos del historial:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al obtener los datos del historial. Por favor, intente de nuevo.'
                });
            }
        });
    });

    // Actualizar historial
            $('#editHistorialForm').submit(function(event) {
                event.preventDefault();
                const historialId = $(this).data('id');
                $.ajax({
                    url: `/historial/actualizar/${historialId}`,
                    type: "PUT",
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    success: function(response) {
                        $('#editHistorialModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: response.message
                        });
                        $('#editHistorialForm')[0].reset();
                        $('#historial-table').DataTable().ajax.reload(); // Recargar tabla de historiales
                    },
                    error: function(error) {
                        console.error('Error al actualizar el registro en el historial:', error);
                        alert('Error al actualizar el registro en el historial. Por favor, intente de nuevo.');
                    }
                });
            });

    // Inicializar DataTable
    $('#historial-table').DataTable({
        language: {
            decimal: "",
            emptyTable: "No hay información",
            info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
            infoFiltered: "(Filtrado de _MAX_ total entradas)",
            lengthMenu: "Mostrar _MENU_ Entradas",
            loadingRecords: "Cargando...",
            processing: "Procesando...",
            search: "Buscar:",
            zeroRecords: "Sin resultados encontrados",
            paginate: {
                first: "Primero",
                last: "Ultimo",
                next: "Siguiente",
                previous: "Anterior"
            }
        },
        processing: true,
        serverSide: true,
        ajax: "{{ route('historiales') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'paciente_id', name: 'paciente_id' },
            { 
                data: 'fechaInicio', 
                name: 'fechaInicio',
                render: function(data) {
                    return moment(data).format('DD-MM-YYYY HH:mm');
                }
            },
            { 
                data: 'fechaFin', 
                name: 'fechaFin',
                render: function(data) {
                    return data ? moment(data).format('DD-MM-YYYY HH:mm') : '';
                }
            },
            { data: 'antecedentes_medicos', name: 'antecedentes_medicos' },
            { data: 'historial_medicamentos', name: 'historial_medicamentos' },
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

    // Manejar eliminación de historial
    $(document).on('click', '.delete-btn', function() {
        const historialId = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo!'
        }).then((result) => {
            if (result.isConfirmed) {
                
                $.ajax({
                    url: `/historiales/eliminar/${historialId}`,
                    type: "DELETE",
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                    },
                    success: function(response) {
                        Swal.fire(
                            '¡Eliminado!',
                            'El historial ha sido eliminado.',
                            'success'
                        );
                        $('#historial-table').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        console.error('Error al eliminar el historial:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al eliminar el historial. Por favor, intente de nuevo.'
                        });
                    }
                });
            }
        });
    });


        
        // Toggle para dark mode y light mode
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
                modeText.innerText = "Light mode";
            } else {
                modeText.innerText = "Dark mode";     
            }
        });
    });


</script>

</body>
</html>
