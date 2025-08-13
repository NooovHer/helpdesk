<?php
// app/Http/Controllers/Admin/UserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\Computer;
use App\Models\Company;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */


    public function create()
    {
        $computers = Computer::all();
        $companies = Company::all();
        return view('admin.users.create', compact('computers', 'companies'));
    }


    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'username'      => 'required|string|max:255|unique:users,username',
            'email'         => 'required|email|max:255|unique:users,email',
            'password'      => 'required|string|confirmed|min:8',
            'role'          => ['required', Rule::in(['admin', 'employee', 'manager'])],
            'id_employee'   => 'nullable|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'hire_date'     => 'nullable|date',
            'status'        => ['required', Rule::in(['active', 'inactive', 'suspended'])],
            'empresa_id'    => 'nullable|exists:companies,id',
        ]);

        $user = new User(collect($data)->except('password')->toArray());
        $user->password = Hash::make($data['password']);
        $user->empresa_id = $data['empresa_id'] ?? null;
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $companies = Company::all();
        return view('admin.users.edit', compact('user', 'companies'));
    }
    public function show($id)
    {
        $user = User::with('pc')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }
    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'username'      => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($user->id)],
            'email'         => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password'      => 'nullable|string|confirmed|min:8',
            'role'          => ['required', Rule::in(['admin', 'employee', 'manager'])],
            'id_employee'   => 'nullable|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'hire_date'     => 'nullable|date',
            'status'        => ['required', Rule::in(['active', 'inactive', 'suspended'])],
            'empresa_id'    => 'nullable|exists:companies,id',
        ]);

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->fill(collect($data)->except('password')->toArray());
        $user->empresa_id = $data['empresa_id'] ?? null;
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
