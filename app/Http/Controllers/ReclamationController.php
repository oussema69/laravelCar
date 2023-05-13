<?php

namespace App\Http\Controllers;
use App\Models\Reclamation;
use App\Models\Intervention;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReclamationController extends Controller
{
    public function createReclamation(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|integer|exists:cars,id',
            'repartition' => 'boolean',
            'desinstallation' => 'boolean',
            'reinstallation' => 'boolean',
            'nouvelinstallation' => 'boolean',
            'option' => 'boolean',
            'sim' => 'boolean',
            'isValid' => 'boolean',
        ]);

        // If validation fails, return an error message
        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    'message' => $validator->errors()->first()
                ]
            ], 400);
        }

        // Create a new reclamation with the request data
        $reclamation = new Reclamation([
            'car_id' => $request->input('car_id'),
            'repartition' => $request->input('repartition', false),
            'desinstallation' => $request->input('desinstallation', false),
            'reinstallation' => $request->input('reinstallation', false),
            'nouvelinstallation' => $request->input('nouvelinstallation', false),
            'option' => $request->input('option', false),
            'sim' => $request->input('sim', false),
            'isValid' => $request->input('isValid', false),
        ]);

        // Save the reclamation to the database
        $reclamation->save();

        // Return a success message and the details of the new reclamation
        return response()->json([
            'message' => 'Reclamation created successfully',
            'reclamation' => $reclamation
        ], 201);
    }
    public function getAll()
{
    $reclamations = Reclamation::all();
    return response()->json($reclamations);
}
public function getByUserId($userId)
{
    $reclamations = Reclamation::whereHas('car', function ($query) use ($userId) {
        $query->where('car_id', $userId);
    })->get();
    return response()->json($reclamations);
}
public function getById($id)
{
    $reclamation = Reclamation::find($id);
    if (!$reclamation) {
        return response()->json(['message' => 'Reclamation not found'], 404);
    }
    return response()->json($reclamation);
}
public function getReclamationsByUserId($user_id)
{
    $reclamations = DB::table('reclamations')
        ->join('cars', 'reclamations.car_id', '=', 'cars.id')
        ->join('users', 'cars.user_id', '=', 'users.id')
        ->select('reclamations.*')
        ->where('users.id', '=', $user_id)
        ->get();

    return response()->json($reclamations, 200);
}
public function delete($id)
{
    $reclamation = Reclamation::find($id);
    if (!$reclamation) {
        return response()->json(['message' => 'Reclamation not found'], 404);
    }
    $reclamation->delete();
    return response()->json(['message' => 'Reclamation deleted successfully']);
}
public function update(Request $request, $id)
{
    // Find the reclamation by ID
    $reclamation = Reclamation::findOrFail($id);

    // Update the reclamation with the request data
    $reclamation->fill([
        'repartition' => $request->input('repartition'),
        'desinstallation' => $request->input('desinstallation'),
        'reinstallation' => $request->input('reinstallation'),
        'nouvelinstallation' => $request->input('nouvelinstallation'),
        'option' => $request->input('option'),
        'sim' => $request->input('sim'),
        'isValid' => $request->input('isValid'),
        'car_id' => $request->input('car_id'),

    ]);
    $reclamation->save();

    // Return a success message and the updated reclamation data
    return response()->json([
        'message' => 'Reclamation updated successfully',
        'reclamation' => $reclamation
    ], 200);
}
public function getByTechId($userId)
{
    $interventions = Intervention::where('user_id', $userId)->get();
    $reclamations = Reclamation::whereIn('id', $interventions->pluck('reclamation_id'))->get();

    return response()->json(['data' => $reclamations]);
}
public function index()
{
    $reclamations = Reclamation::where('isValid', false)->get();
    return response()->json($reclamations, 200);
}
public function updateReclamationIsValid($id)
{
    $reclamation = Reclamation::findOrFail($id);
    $reclamation->isValid = true;
    $reclamation->save();

    return response()->json([
        'message' => 'Reclamation updated successfully',
        'data' => $reclamation
    ]);
}



}
