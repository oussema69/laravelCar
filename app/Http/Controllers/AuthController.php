<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
class AuthController extends Controller
{
    public function auth(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            $token = $user->createToken('access_token')->accessToken;
            return response()->json([
                'message' => 'Authentication successful',
                'user' => $user,
                'access_token' => $token
            ], 200);
        } else {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }
    }
    public function createUser(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:6|max:255',
            'tel' => 'required|string|max:10',
            'role' => 'required|integer',
        ], [
            'required' => 'The :attribute field is required.',
            'email' => 'The :attribute must be a valid email address.',
            'unique' => 'The :attribute is already taken.',
            'integer' => 'The :attribute field must be an integer.',
            'string' => 'The :attribute field must be a string.',
            'max' => 'The :attribute field must be no more than :max characters.',
            'min' => 'The :attribute field must be at least :min characters.',
        ]);

        if ($validator->fails()) {
            // Return validation error messages
            return response()->json([
                'error' => [
                    'message' => $validator->errors()->first(),
                ]
            ], 422);
        }

        // Create the new user
        $user = new User;
        $user->nom = $request->input('nom');
        $user->prenom = $request->input('prenom');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->tel = $request->input('tel');
        $user->role = $request->input('role');

        if (!$user->save()) {
            // Return an error response if the user couldn't be saved
            return response()->json([
                'message' => 'Error creating user',
            ], 500);
        }

        // Generate and return a success response
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);
    }

    public function createContact(Request $request)
    {
        $contact = Contact::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'number' => $request->input('number'),
            'message' => $request->input('message')
        ]);

        return response()->json([
            'message' => 'Contact created successfully',
            'contact' => $contact
        ], 201);
    }
    public function getContact()
{
    $contacts = Contact::all();
    return response()->json($contacts);
}
public function delete($id)
{
    $contact = Contact::find($id);
    if (!$contact) {
        return response()->json(['error' => 'Contact not found'], 404);
    }
    $contact->delete();
    return response()->json(['message' => 'Contact deleted successfully'], 200);
}







}
