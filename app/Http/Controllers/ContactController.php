<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function login(): View
    {
        return view('admin.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            $request->session()->put('admin_authenticated', true);
            return redirect()->route('admin.dashboard');
        }

        $email = (string) config('portfolio.admin_email');
        $passwordHash = (string) config('portfolio.admin_password_hash');

        if (hash_equals($email, $data['email']) && Hash::check($data['password'], $passwordHash)) {
            $user = User::query()->firstOrCreate(
                ['email' => $email],
                [
                    'name' => 'Angélica Cuéllar',
                    'password' => $passwordHash,
                ]
            );

            Auth::login($user);
            $request->session()->regenerate();
            $request->session()->put('admin_authenticated', true);
            $request->session()->put('admin_email', $email);

            return redirect()->route('admin.dashboard');
        }

        return back()
            ->withErrors(['email' => 'Las credenciales no son válidas.'])
            ->onlyInput('email');
    }

    public function store(Request $request): RedirectResponse
    {
        $backToForm = redirect()->to(route('portfolio.show').'#contacto');
        $sent = 'Gracias, tu mensaje llegó. Te responderé pronto.';

        // Honeypot: los bots llenan el campo oculto "website"; se descarta sin avisarles.
        if (filled($request->input('website'))) {
            return $backToForm->with('status', $sent);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'company' => ['nullable', 'string', 'max:160'],
            'message' => ['required', 'string', 'min:10', 'max:1500'],
        ], [
            'name.required' => 'Escribe tu nombre.',
            'name.max' => 'El nombre puede tener máximo :max caracteres.',
            'email.required' => 'Escribe tu correo para poder responderte.',
            'email.email' => 'Revisa el correo: debe tener el formato nombre@dominio.com.',
            'email.max' => 'El correo puede tener máximo :max caracteres.',
            'company.max' => 'El nombre de la marca puede tener máximo :max caracteres.',
            'message.required' => 'Cuéntame en qué te puedo ayudar.',
            'message.min' => 'El mensaje es muy corto: escribe al menos :min caracteres.',
            'message.max' => 'El mensaje puede tener máximo :max caracteres.',
        ]);

        if ($validator->fails()) {
            return $backToForm->withErrors($validator)->withInput();
        }

        ContactMessage::create([
            ...$validator->validated(),
            'ip_address' => $request->ip(),
        ]);

        return $backToForm->with('status', $sent);
    }

    public function index(Request $request): View|RedirectResponse
    {
        if (! (bool) $request->session()->get('admin_authenticated', false) && ! Auth::check()) {
            return redirect()->route('admin.login');
        }

        return view('admin.messages', [
            'messages' => ContactMessage::latest()->get(),
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
