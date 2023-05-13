<?php

namespace App\Http\Controllers;
use App\Models\Tache;

use Illuminate\Http\Request;

class TacheController extends Controller
{
    public function store(Request $request)
    {
        try {
            $tasks = $request->input('tasks');
            
            $taches = collect([]);
            foreach ($tasks as $task) {
                $tache = Tache::create([
                    'categorie' => $task['categorie'],
                    'type' => $task['type'],
                    'value' => $task['value'],
                    'intervention_id' => $task['intervention_id'],
                ]);
                $taches->push($tache);
            }
    
            return response()->json(['taches' => $taches], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating taches: ' . $e->getMessage()], 500);
        }
    }
    
public function update(Request $request, $id)
{
    $tache = Tache::find($id);

    if (!$tache) {
        return response()->json(['message' => 'Tache not found'], 404);
    }

    $tache->categorie = $request->input('categorie');
    $tache->type = $request->input('type');
    $tache->value = $request->input('value');
    $tache->intervention_id = $request->input('intervention_id');

    if (!$tache->save()) {
        return response()->json(['message' => 'Error updating tache'], 500);
    }

    return response()->json(['message' => 'Tache updated successfully', 'tache' => $tache], 200);
}
public function delete($id)
{
    $tache = Tache::find($id);

    if (!$tache) {
        return response()->json(['message' => 'Tache not found'], 404);
    }

    $tache->delete();

    return response()->json(['message' => 'Tache deleted'], 200);
}
public function getById($id)
{
    $tache = Tache::findOrFail($id);
    return $tache;
}
public function getTachesByInterventionId($id)
{
    $taches = Tache::where('intervention_id', $id)->get();

    return response()->json($taches);
}

public function getByType($type, $intervention_id)
{
    $taches = Tache::where('type', $type)->where('intervention_id', $intervention_id)->get();

    if($taches->isEmpty()) {
        return null;
    }

    return response()->json($taches, 200);
}


}
