<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST USER
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $users = User::with('role')
            ->latest()
            ->get();

        return view(
            'users.index',
            compact('users')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH USER
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $roles = Role::all();

        return view(
            'users.create',
            compact('roles')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN USER
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|max:255',
            'email'     => 'required|email|unique:users,email',
            'role_id'   => 'required',
            'password'  => 'required|min:6|confirmed'
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'role_id'   => $request->role_id,
            'password'  => Hash::make(
                $request->password
            ),
        ]);

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'User berhasil ditambahkan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL USER
    |--------------------------------------------------------------------------
    */

    public function show(User $user)
    {
        return view(
            'users.show',
            compact('user')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT USER
    |--------------------------------------------------------------------------
    */

    public function edit(User $user)
    {
        $roles = Role::all();

        return view(
            'users.edit',
            compact(
                'user',
                'roles'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE USER
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        User $user
    ) {
        $request->validate([
            'name'    => 'required|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required',
        ]);

        $data = [
            'name'    => $request->name,
            'email'   => $request->email,
            'role_id' => $request->role_id,
        ];

        if ($request->filled('password')) {

            $request->validate([
                'password' => 'confirmed|min:6'
            ]);

            $data['password'] =
                Hash::make(
                    $request->password
                );
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'User berhasil diperbarui.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS USER
    |--------------------------------------------------------------------------
    */

   public function destroy(User $user)
{
    if ($user->id === Auth::id()) {

        return back()->with(
            'error',
            'Tidak dapat menghapus akun yang sedang digunakan.'
        );
    }

    $user->delete();

    return redirect()
        ->route('users.index')
        ->with(
            'success',
            'User berhasil dihapus.'
        );
}
}