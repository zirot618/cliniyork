<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Medico;
use App\Models\Administrador;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    public function index()
    {
    
        $users = User::all(); 

       
        $userData = [];
        foreach ($users as $user) {
            $userData[] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at->format('Y-m-d'), 
            ];
        }
        return $users; 

        
    }

    public function crearUser(Request $request)
    {
    // Validación de campos
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'cedula' => 'required|string|max:20|unique:users,cedula',
        'rol' => 'required|in:paciente,medico,administrador',
        'telefono' => 'required|string|max:20',
        'direccion' => 'required|string|max:255',
        'password'  =>'required|string|min:8'
    ]);

    
    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->cedula = $request->cedula;
    $user->rol = $request->rol;
    $user->telefono = $request->telefono;
    $user->direccion = $request->direccion;
    $user->password = $request->password;
    $user->save();  

    // Guardar el ID del usuario en la tabla correspondiente
    if ($user->rol == 'medico') {
        // Lista de especialidades
        $especialidades = [1, 2, 3, 4, 5]; // IDs de especialidades de ejemplo
        $especialidad_aleatoria = $especialidades[array_rand($especialidades)];
        
        Medico::updateOrCreate(
            ['user_id' => $user->id],
            ['especialidad' => $especialidad_aleatoria]
        );
    } elseif ($user->rol == 'administrador') {
        Administrador::updateOrCreate(['user_id' => $user->id]);
    } elseif ($user->rol == 'paciente') {
        Paciente::updateOrCreate(['user_id' => $user->id]);
    }

    return response()->json(['message' => 'Usuario actualizado correctamente']);
    }


    public function doctores()
    {
    
        $doctors = User::where('rol', 'medico')->get();

       
        $userData = [];
        foreach ($doctors as $doctor) {
            $userData[] = [
                'id' => $doctor->id,
                'name' =>$doctor->name,
                'email' => $doctor->email,
                'rol' =>$doctor->rol,
                'created_at' => $doctor->created_at->format('Y-m-d'), 
            ];
        }
        return $doctors; 

        
    }

    public function pacientes()
    {
    
        $pacientes = User::where('rol', 'paciente')->get();

       
        $userData = [];
        foreach ($pacientes as $paciente) {
            $userData[] = [
                'id' => $paciente->id,
                'name' =>$paciente->name,
                'email' => $paciente->email,
                'rol' =>$paciente->rol,
                'created_at' => $paciente->created_at->format('Y-m-d'), 
            ];
        }
        return $pacientes; 

    }

    public function actualizarUser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Validar los datos del formulario de edición
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'cedula' => 'required|string|max:255',
            'rol' => 'required|in:paciente,medico,administrador', 
            'telefono' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
        ]);

        // Actualizar los campos del usuario
        $user->name = $request->name;
        $user->email = $request->email;
        $user->cedula = $request->cedula;
        $user->rol = $request->rol;
        $user->telefono = $request->telefono;
        $user->direccion = $request->direccion;
        $user->save();

        // Guardar el ID del usuario en la tabla correspondiente
        if ($user->rol == 'medico') {
            $especialidades = [1, 2, 3, 4, 5]; // IDs de especialidades de ejemplo
            $especialidad_aleatoria = $especialidades[array_rand($especialidades)];
            
            Medico::updateOrCreate(
                ['user_id' => $user->id],
                ['especialidad' => $especialidad_aleatoria]
            );

            // Eliminar de otras tablas si existen registros antiguos
            Administrador::where('user_id', $user->id)->delete();
            Paciente::where('user_id', $user->id)->delete();
        } elseif ($user->rol == 'administrador') {
            Administrador::updateOrCreate(['user_id' => $user->id]);

            // Eliminar de otras tablas si existen registros antiguos
            Medico::where('user_id', $user->id)->delete();
            Paciente::where('user_id', $user->id)->delete();
        } elseif ($user->rol == 'paciente') {
            Paciente::updateOrCreate(['user_id' => $user->id]);

            // Eliminar de otras tablas si existen registros antiguos
            Medico::where('user_id', $user->id)->delete();
            Administrador::where('user_id', $user->id)->delete();
        }

        return response()->json(['message' => 'Usuario actualizado correctamente']);
    }

    public function eliminarUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Eliminar también de las tablas relacionadas sin importar las claves foráneas
        Medico::where('user_id', $user->id)->delete();
        Administrador::where('user_id', $user->id)->delete();
        Paciente::where('user_id', $user->id)->delete();

        // Finalmente, eliminar el usuario
        $user->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }

    public function logeado()
    {
        $user = Auth::user();
        return view('citas', compact('user'));
    }
}