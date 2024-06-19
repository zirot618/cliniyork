<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistorialMedico;
use Illuminate\Support\Facades\Validator;
use App\Models\Paciente;
use App\Models\User;   
class HistorialMedicoController extends Controller
{

    public function index()
    {
        $historiales = HistorialMedico::with('paciente')->get();
        $pacientes = Paciente::all();

        return view('historialmedico', compact('historiales', 'pacientes'));
    }
    public function crearHistorial(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fechaInicio' => 'required|date',
            'fechaFin' => 'nullable|date',
            'antecedentes_medicos' => 'nullable|string',
            'historial_medicamentos' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $paciente_id = Paciente::where('user_id', $request->input('paciente_id'))->value('id');

        $historialMedico = new HistorialMedico;
        $historialMedico->paciente_id = $paciente_id;
        $historialMedico->fechaInicio = $request->input('fechaInicio');
        $historialMedico->fechaFin = $request->input('fechaFin');
        $historialMedico->antecedentes_medicos = $request->input('antecedentes_medicos');
        $historialMedico->historial_medicamentos = $request->input('historial_medicamentos');
        $historialMedico->save();

        return response()->json([
            'success' => true,
            'message' => 'Historial médico creado con éxito!',
            'historial_medico' => $historialMedico,
        ], 201);
    }

    public function editarHistorial(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'fechaInicio' => 'required|date',
        'fechaFin' => 'nullable|date',
        'antecedentes_medicos' => 'nullable|string',
        'historial_medicamentos' => 'nullable|string',
 
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    $historial = HistorialMedico::find($id);
        if (!$historial) {
            return response()->json(['message' => 'historial no encontrado'], 404);
        }

    $paciente_id = Paciente::where('user_id', $request->input('paciente_id'))->value('id');
    

    if (!$paciente_id) {
        return response()->json(['message' => 'No se encontró un paciente con el user_id proporcionado'], 404);
    }


    // Actualizar el historial médico con los datos recibidos
    $historialMedico->paciente_id = $paciente->id;
    $historialMedico->fechaInicio = $request->input('fechaInicio');
    $historialMedico->fechaFin = $request->input('fechaFin');
    $historialMedico->antecedentes_medicos = $request->input('antecedentes_medicos');
    $historialMedico->historial_medicamentos = $request->input('historial_medicamentos');
    $historialMedico->save();

    return response()->json([
        'message' => 'Historial médico actualizado exitosamente',
        'historial_medico' => $historialMedico,
    ], 200);
}
    public function getHistoriales()
    {
        $historiales = HistorialMedico::with('paciente')->get();
        return response()->json(['data' => $historiales], 200);
    }

    public function mostrarHistorial($id)
    {
        $historial = HistorialMedico::find($id);
        if (!$historial) {
            return response()->json(['message' => 'Historial no encontrado'], 404);
        }

        return response()->json(['historial' => $historial]);
    }

    public function eliminarHistorial($id)
    {
        $historial = HistorialMedico::find($id);
        if (!$historial) {
            return response()->json(['message' => 'Historial no encontrado no encontrada'], 404);
        }

        $historial->delete();
        return response()->json(['message' => 'Historial eliminado con éxito']);
    }

}
