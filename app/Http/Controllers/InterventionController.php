<?php

namespace App\Http\Controllers;
use App\Models\Intervention;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class InterventionController extends Controller
{
    public function store(Request $request)
    {
        // Validate input data
    $validator = Validator::make($request->all(), [
        'date' => 'required|date',
        'user_id' => 'required|exists:users,id',
        'reclamation_id' => 'required|exists:reclamations,id',
        'autre' => 'nullable|string',
    ]);

    // If validation fails, return error response with message
    if ($validator->fails()) {
        return response()->json(['message' => $validator->errors()->first()], 422);
    }

    // Otherwise, create new intervention and return success response
    $intervention = Intervention::create([
        'date' => $request->input('date'),
        'user_id' => $request->input('user_id'),
        'reclamation_id' => $request->input('reclamation_id'),
        'autre' => $request->input('autre'),
    ]);

return response()->json([
    'message' => 'Intervention created successfully',
    'intervention' => $intervention
], 201);}
public function getInterventionsByUser($user_id)
{
    $interventions = Intervention::where('user_id', $user_id)->get();

    if ($interventions->isEmpty()) {
return null;    }

    return response()->json(['interventions' => $interventions], 200);
}
public function getByReclamationId($id)
{
    $intervention = Intervention::where('reclamation_id', $id)->first();
    
    if(!$intervention) {
       return False;
    }
    
    return response()->json($intervention, 200);
}


public function getInterventionById($id)
{
    $intervention = Intervention::find($id);

    if (!$intervention) {
        return response()->json(['message' => 'Intervention not found'], 404);
    }

    return response()->json($intervention, 200);
}
public function update(Request $request, $id)
{
    $intervention = Intervention::find($id);

    if (!$intervention) {
        return response()->json(['error' => 'Intervention not found'], 404);
    }

    $intervention->date = $request->input('date');
    $intervention->autre = $request->input('autre');
    $intervention->user_id = $request->input('user_id');
    $intervention->reclamation_id = $request->input('reclamation_id');
    $intervention->save();

    return response()->json(['message' => 'Intervention updated successfully'], 200);
}
public function deleteIntervention($id)
{
    $intervention = Intervention::find($id);
    
    if(!$intervention) {
        return response()->json(['message' => 'Intervention not found'], 404);
    }
    
    $intervention->delete();
    
    return response()->json(['message' => 'Intervention deleted successfully'], 200);
}



}