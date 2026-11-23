<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    private function authorizeAdmin(Request $request): ?RedirectResponse
    {
        if (! $request->session()->get('admin_authenticated', false) && ! Auth::check()) {
            return redirect()->route('admin.login');
        }

        if (! Auth::check()) {
            $user = User::query()->first();
            if (! $user) {
                $user = User::query()->create([
                    'name' => 'Angélica Cuéllar',
                    'email' => (string) config('portfolio.admin_email', 'admin@example.com'),
                    'password' => (string) config('portfolio.admin_password_hash'),
                ]);
            }
            Auth::login($user);
        }

        return null;
    }

    public function index(Request $request): View|RedirectResponse
    {
        if ($redirect = $this->authorizeAdmin($request)) {
            return $redirect;
        }

        $users = User::query()->orderBy('created_at', 'desc')->get();
        $messagesCount = ContactMessage::query()->count();
        $currentUser = Auth::user();

        return view('admin.users', compact('users', 'messagesCount', 'currentUser'));
    }

    public function store(Request $request): RedirectResponse
    {
        if ($redirect = $this->authorizeAdmin($request)) {
            return $redirect;
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.users.index')->with('status', "El usuario {$user->name} fue creado exitosamente.");
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        if ($redirect = $this->authorizeAdmin($request)) {
            return $redirect;
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'Este correo electrónico ya pertenece a otro usuario.',
            'password.min' => 'La nueva contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);

        $dataToUpdate = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (! empty($validated['password'])) {
            $dataToUpdate['password'] = Hash::make($validated['password']);
        }

        $user->update($dataToUpdate);

        return redirect()->route('admin.users.index')->with('status', "El usuario {$user->name} fue actualizado correctamente.");
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        if ($redirect = $this->authorizeAdmin($request)) {
            return $redirect;
        }

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'current_password.required' => 'Debes ingresar tu contraseña actual.',
            'current_password.current_password' => 'La contraseña actual ingresada es incorrecta.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.min' => 'La nueva contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.users.index')->with('status', 'Tu contraseña se ha actualizado correctamente.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($redirect = $this->authorizeAdmin($request)) {
            return $redirect;
        }

        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'No puedes eliminar la cuenta con la que estás con sesión activa.');
        }

        if (User::query()->count() <= 1) {
            return redirect()->route('admin.users.index')->with('error', 'No es posible eliminar el único usuario del sistema.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')->with('status', "El usuario {$userName} ha sido eliminado.");
    }
}
