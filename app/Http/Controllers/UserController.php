<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    public function createUser()
    {
        return view('admin/users/user-create');
    }

    public function saveUser(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => ['required', Rule::in(['Alumno', 'Profesor', 'Administrador'])],
            'password' => 'required|string|min:8|confirmed',
        ], [
            'confirmed' => 'Las contraseñas deben coincidir.',
            'unique' => 'El correo ya está en uso.',
            'required' => 'El campo es obligatorio.',
            'min' => 'El campo debe tener al menos :min caracteres.',
            'max' => 'El campo no puede tener más de :max caracteres.',
            'email' => 'El correo no es válido.',
            'string' => 'El campo debe ser una cadena de caracteres.',
            'role.required' => 'El campo es obligatorio.',
            'role.in' => 'Valor incorrecto',
        ]);

        $user = new User();

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->role = $validatedData['role'];
        $user->password = bcrypt($validatedData['password']); 
        
        $user->save();

        return response()->json(['message' => 'Usuario creado correctamente.'], 200);
    }

    public function showUsers()
    {
        //Obtener todas la info de los usuarios
        $users = User::all();

        //Retornar la vista con todos los usuarios
        return view('admin/users/users', compact('users'));
    }
    
    public function showUserInfo($id)
    {
        //Obtener toda la info de un usuario
        $user = User::findOrFail($id);

        //Retornar la vista con la info del usuario
        return view('admin/users/user-info', compact('user'));
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users')->with('success', 'Usuario eliminado correctamente.');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin/users/user-edit', compact('user')); 
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Regla de validación de email
        $emailRule = 'required|email|unique:users,email,' . $id . ',id';

        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => $emailRule,
            'role' => ['required', Rule::in(['Alumno', 'Profesor', 'Administrador'])],
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'confirmed' => 'Las contraseñas deben coincidir.',
            'unique' => 'El correo ya está en uso.',
            'required' => 'El campo es obligatorio.',
            'min' => 'El campo debe tener al menos :min caracteres.',
            'max' => 'El campo no puede tener más de :max caracteres.',
            'email' => 'El correo no es válido.',
            'string' => 'El campo debe ser una cadena de caracteres.',
            'role.required' => 'El campo es obligatorio.',
            'role.in' => 'Valor incorrecto',
        ]);

        // Si la contraseña no está vacía, la encriptamos y la guardamos
        if (!empty($validatedData['password']))
        {
            $user->password = bcrypt($validatedData['password']);
        }
        else
        {
            unset($validatedData['password']);
        }
    
        $user->update($validatedData);

        return response() -> json([
            'success' => true,
            'message' => 'Usuario actualizado correctamente.',
            'datos' => $validatedData,
        ]);
    }
}