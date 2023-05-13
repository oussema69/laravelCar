<?php

namespace App\Http\Controllers;
use App\Models\Car;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class CarController extends Controller
{
    public function delete($id)
{
    $car = Car::find($id);

    if ($car) {
        $car->delete();
        return response()->json(['message' => 'Car deleted successfully.']);
    } else {
        return response()->json(['message' => 'Car not found.'], 404);
    }
}
public function store(Request $request)
{
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'matricule' => 'required|unique:cars|max:255',
        'model' => 'required|max:255',
        'user_id' => 'required|integer',
    ]);

    // If validation fails, return an error message
    if ($validator->fails()) {
        $errors = $validator->errors();
        $errorMessage = $errors->first();
        return response()->json([
            'error' => [
                'message' => $errorMessage
            ]
        ], 400);
    }

    // Create a new car with the request data
    $car = new Car([
        'matricule' => $request->input('matricule'),
        'model' => $request->input('model'),
        'user_id' => $request->input('user_id'),
    ]);

    // Save the car to the database
    $car->save();

    // Return a success message and the details of the new car
    return response()->json([
        'message' => 'Car created successfully',
        'car' => $car
    ], 201);
}
public function getCarsByUserId($user_id)
{
    $cars = Car::where('user_id', $user_id)->get();

    if($cars->isEmpty()) {
        return response()->json(['message' => 'No cars found for the given user ID.'], 404);
    }

    return response()->json($cars, 200);
}
public function update(Request $request, $id)
{
    $car = Car::find($id);
    if (!$car) {
        return response()->json(['error' => 'Car not found'], 404);
    }

    $validatedData = $request->validate([
        'matricule' => 'string|max:255|unique:cars,matricule,'.$car->id,
        'model' => 'string|max:255',
        'user_id' => 'exists:users,id',
    ]);


    $car->fill($validatedData);
    $car->save();

    return response()->json(['message' => 'Car updated successfully']);
}

public function getCar($id)
{
    // Get the car by ID from the database
    $car = Car::find($id);

    // If the car doesn't exist, return a 404 response
    if (!$car) {
        return response()->json([
            'error' => [
                'message' => 'Car not found'
            ]
        ], 404);
    }

    // If the car exists, return it as a JSON response
    return response()->json([
        'car' => $car
    ]);
}






}
