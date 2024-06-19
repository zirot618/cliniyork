<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Cita;
use App\Models\User;   
use App\Models\Medico;
use Carbon\Carbon;

class CitaController extends Controller
{
    public function index()
    {
        $citas = Cita::all();
        return response()->json(['data' => $citas]);
    }

    public function getCitasForCalendar()
    {
        // Obtener todas las citas en un formato adecuado para FullCalendar
        $citas = Cita::select('id', 'motivo', 'fechaHora')->get();

        // Formatear los datos de citas en el formato requerido por FullCalendar
        $formattedCitas = $citas->map(function ($cita) {
            // Convertir fechaHora a objeto Carbon si es una cadena
            $start = Carbon::parse($cita->fechaHora);

            return [
                'title' => $cita->motivo,
                'start' => $start->toDateTimeString(),
                // Puedes añadir más propiedades como 'end' si es necesario
            ];
        });

        return response()->json($formattedCitas);
    }


    public function crearCita(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fechaHora' => 'required|date_format:Y-m-d\TH:i',
            'motivo' => 'required|string|max:255',
            'medico_id' => 'required|integer',
            'estado' => 'nullable|string|in:pendiente,aprobada,finalizada',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = auth()->user();

        if (!$user->paciente) {
            return response()->json(['message' => 'El usuario no tiene un perfil de paciente asociado'], 404);
        }

        // Obtener el medico_id asociado al user_id proporcionado en la solicitud
        $medico_id = Medico::where('user_id', $request->input('medico_id'))->value('id');

        if (!$medico_id) {
            return response()->json(['message' => 'No se encontró un médico con el user_id proporcionado'], 404);
        }

        $paciente_id = $user->paciente->id;

        $cita = new Cita;
        $cita->fechaHora = $request->input('fechaHora');
        $cita->motivo = $request->input('motivo');
        $cita->medico_id = $medico_id; // Asignar el id del médico encontrado
        $cita->paciente_id = $paciente_id;
        $cita->estado = $request->input('estado', 'pendiente');
        $cita->save();

        return response()->json([
            'success' => true,
            'message' => 'Cita agendada con éxito!',
            'cita' => $cita,
        ], 201);
    }

    public function editarCita(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fechaHora' => 'required|date_format:Y-m-d\TH:i',
            'motivo' => 'required|string|max:255',
            'medico_id' => 'required|integer',
            'estado' => 'nullable|string|in:pendiente,aprobada,finalizada',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $cita = Cita::find($id);
        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        $medico_id = Medico::where('user_id', $request->input('medico_id'))->value('id');

        if (!$medico_id) {
            return response()->json(['message' => 'No se encontró un médico con el user_id proporcionado'], 404);
        }

        $cita->fechaHora = $request->input('fechaHora');
        $cita->motivo = $request->input('motivo');
        $cita->medico_id = $medico_id;
        $cita->estado = $request->input('estado', $cita->estado); // Mantener el estado actual si no se proporciona
        $cita->save();

        return response()->json(['message' => 'Cita actualizada con éxito', 'cita' => $cita]);
    }

    public function eliminarCita($id)
    {
        $cita = Cita::find($id);
        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        $cita->delete();
        return response()->json(['message' => 'Cita eliminada con éxito']);
    }

    public function mostrarCita($id)
    {
        $cita = Cita::find($id);
        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        return response()->json(['cita' => $cita]);
    }
}