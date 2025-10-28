<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

// Este controlador es para que el Administrador gestione otros usuarios y asigne roles.

class UserController extends Controller
{
    /**
     * Muestra la lista de usuarios.
     */
    public function index(): View
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Muestra el formulario de creación.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Guarda un nuevo usuario.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // Valida que el rol sea uno de los definidos
            'role' => ['required', 'string', Rule::in(['admin', 'guardaparque', 'user'])],
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
            'email_verified_at' => now(),
        ]);

        return redirect()->route('administracion.usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit(User $usuario): View
    {
        // Se asume que el binding de ruta encuentra el usuario, si no, usa: User::findOrFail($id)
        return view('admin.users.edit', compact('usuario'));
    }

    /**
     * Actualiza un usuario.
     */
    public function update(Request $request, User $usuario): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'role' => ['required', 'string', Rule::in(['admin', 'guardaparque', 'user'])],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
        ];

        if (!empty($validatedData['password'])) {
            $data['password'] = Hash::make($validatedData['password']);
        }

        $usuario->update($data);

        return redirect()->route('administracion.usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Elimina un usuario.
     */
    public function destroy(User $usuario): RedirectResponse
    {
        $usuario->delete();
        return redirect()->route('administracion.usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
