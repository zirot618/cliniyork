<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--======== CSS ======== -->
    <link rel="stylesheet" href="{{ asset('assets/usuarios.css') }}">
    
    <!--===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    
    <!--===== DataTables CSS ===== -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <!--===== Font Awesome ===== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!--===== Bootstrap =====-->
    
    <title>Panel de Usuario - Clínica</title>
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

    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Crear Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario de Creación -->
                <form id="createUserForm">
                    @csrf <!-- Campo CSRF -->
                    <div class="mb-3">
                        <label for="createName" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="createName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="createEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="createEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="createCedula" class="form-label">Cédula</label>
                        <input type="text" class="form-control" id="createCedula" name="cedula" required>
                    </div>
                    <div class="mb-3">
                        <label for="createRol" class="form-label">Rol</label>
                        <select class="form-select" id="createRol" name="rol" required>
                            <option value="paciente">Paciente</option>
                            <option value="medico">Medico</option>
                            <option value="administrador">Administrador</option>
                            <!-- Asegúrate de agregar todas las opciones de rol necesarias -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="createTelefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="createTelefono" name="telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="createDireccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="createDireccion" name="direccion" required>
                    </div>
                    <div class="mb-3">
                        <label for="createPassword" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="createPassword" name="password" required>
                            <button class="btn btn-outline-secondary" type="button" id="showCreatePasswordBtn">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Crear Usuario</button>
                </form>
            </div>
        </div>
    </div>
</div>

    
    <!-- Modal de Edición -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario de Edición -->
                <form id="editUserForm">
                    @csrf <!-- Campo CSRF -->
                    @method('PUT') <!-- Campo _method para indicar PUT -->
                    <div class="mb-3">
                        <label for="editName" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCedula" class="form-label">Cédula</label>
                        <input type="text" class="form-control" id="editCedula" name="cedula" required>
                    </div>
                    <div class="mb-3">
                        <label for="editRol" class="form-label">Rol</label>
                        <select class="form-select" id="editRol" name="rol" required>
                            <option value="paciente">Paciente</option>
                            <option value="medico">Medico</option>
                            <option value="administrador">Administrador</option>
                            <!-- Asegúrate de agregar todas las opciones de rol necesarias -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editTelefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="editTelefono" name="telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDireccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="editDireccion" name="direccion" required>
                    </div>
                    <input type="hidden" id="editUserId" name="id">
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Usuarios Registrados</h4>
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createUserModal">
                            Crear Usuario
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="usersTable" class="table table-striped table-bordered" >
                                <thead>                   
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Cédula</th>
                                        <th scope="col">Rol</th>
                                        <th scope="col">Teléfono</th>
                                        <th scope="col">Dirección</th>
                                        <th scope="col">Acciones</th> <!-- Nueva columna de acciones -->
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

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
    $(document).ready(function() {
        // Mostrar/Ocultar contraseña en el formulario de creación
        $('#showCreatePasswordBtn').click(function() {
            var passwordField = $('#createPassword');
            var fieldType = passwordField.attr('type');

            if (fieldType === 'password') {
                passwordField.attr('type', 'text');
                $(this).html('<i class="fa fa-eye-slash"></i>');
            } else {
                passwordField.attr('type', 'password');
                $(this).html('<i class="fa fa-eye"></i>');
            }
        });
    });
    </script>
    <script>
        $(document).ready(function() {
    $('#usersTable').DataTable({
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
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ route('users') }}",
            "type": "GET",
            "dataSrc": function(json) {
                console.log(json);
                return json;
            }
        },
        "columns": [
            { "data": "id" },
            { "data": "name" },
            { "data": "email" },
            { "data": "cedula" },
            { "data": "rol" },
            { "data": "telefono" },
            { "data": "direccion" },
            {
                "data": null,
                "defaultContent": `
                    <button class="btn btn-primary btn-sm edit-btn"><i class="fa-solid fa-pen-to-square"></i> </button>
                    <button class="btn btn-danger btn-sm delete-btn"><i class="fa-solid fa-trash"></i></button>`,
                "orderable": false
            }
        ],
        "columnDefs": [
            {
                "targets": -1, // Última columna (acciones)
                "className": "text-center" 
            }
        ]
    });
});

        // Código para manejar el modo oscuro
        const body = document.querySelector('body'),
            sidebar = body.querySelector('nav'),
            toggle = body.querySelector(".toggle"),
            modeSwitch = body.querySelector(".toggle-switch"),
            modeText = body.querySelector(".mode-text");

        toggle.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        });

        searchBtn.addEventListener("click", () => {
            sidebar.classList.remove("close");
        });

        modeSwitch.addEventListener("click", () => {
            body.classList.toggle("dark");

            if (body.classList.contains("dark")) {
                modeText.innerText = "Light mode";
            } else {
                modeText.innerText = "Dark mode";
            }
        });
    </script>
<script>
    $(document).ready(function() {
        // Evento para abrir el modal de edición
        $('#usersTable tbody').on('click', '.edit-btn', function() {
            var data = $('#usersTable').DataTable().row($(this).parents('tr')).data();
            // Llenar el formulario del modal con los datos del usuario
            $('#editUserId').val(data.id);
            $('#editName').val(data.name);
            $('#editEmail').val(data.email);
            $('#editCedula').val(data.cedula);
            $('#editRol').val(data.rol);
            $('#editTelefono').val(data.telefono);
            $('#editDireccion').val(data.direccion);

            // Abrir el modal de edición
            $('#editUserModal').modal('show');
        });

        // Evento para enviar el formulario de edición
        $('#editUserForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var userId = $('#editUserId').val(); // Obtener el ID del usuario a editar

            // Enviar la petición AJAX para actualizar el usuario
            $.ajax({
                url: '/usuarios/actualizar/' + userId,
                method: 'POST', // Utiliza POST en lugar de PUT
                data: formData,
                success: function(response) {
                    // Mostrar SweetAlert de éxito
                    Swal.fire({
                        icon: 'success',
                        title: 'Usuario Actualizado',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    // Cerrar modal después de 1.5 segundos
                    setTimeout(function() {
                        $('#editUserModal').modal('hide');
                    }, 1500);
                    // Recargar la tabla de usuarios si es necesario
                    $('#usersTable').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    // Manejar errores de validación u otros errores
                    var errors = xhr.responseJSON.errors;
                    console.error(errors);
                    // Mostrar SweetAlert de error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al actualizar usuario. Por favor verifica los campos.'
                    });
                }
            });
        });

        // Evento para eliminar un usuario
        $('#usersTable tbody').on('click', '.delete-btn', function() {
            var data = $('#usersTable').DataTable().row($(this).parents('tr')).data();

            // Mostrar confirmación con SweetAlert
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'No podrás revertir esta acción. ¿Deseas eliminar al usuario ' + data.name + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar la petición AJAX para eliminar el usuario
                    $.ajax({
                        url: '/usuarios/eliminar/' + data.id,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // Mostrar SweetAlert de éxito
                            Swal.fire({
                                icon: 'success',
                                title: 'Usuario Eliminado',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            // Recargar la tabla de usuarios
                            $('#usersTable').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            // Mostrar SweetAlert de error si la eliminación falla
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al eliminar usuario. Por favor intenta de nuevo.'
                            });
                        }
                    });
                }
            });
        });
    });

</script>
<script>
    // JavaScript para manejar la creación de usuario
$(document).ready(function() {
    $('#createUserForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        // Enviar la petición AJAX para crear el usuario
        $.ajax({
            url: '/usuarios/crear',
            method: 'POST',
            data: formData,
            success: function(response) {
                // Mostrar SweetAlert de éxito
                Swal.fire({
                    icon: 'success',
                    title: 'Usuario Creado',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });
                // Cerrar modal después de 1.5 segundos
                setTimeout(function() {
                    $('#createUserModal').modal('hide');
                }, 1500);
                // Recargar la tabla de usuarios si es necesario
                $('#usersTable').DataTable().ajax.reload();
            },
            error: function(xhr) {
                // Manejar errores de validación u otros errores
                var errors = xhr.responseJSON.errors;
                console.error(errors);
                // Mostrar SweetAlert de error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al crear usuario. Por favor verifica los campos.'
                });
            }
        });
    });
});
</script>

</body>
</html>
