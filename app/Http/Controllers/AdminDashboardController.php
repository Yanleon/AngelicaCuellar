<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(Request $request): View|RedirectResponse
    {
        if (! (bool) $request->session()->get('admin_authenticated', false)) {
            return redirect()->route('admin.login');
        }

        return view('admin.dashboard', [
            'messagesCount' => ContactMessage::count(),
            'latestMessages' => ContactMessage::latest()->take(3)->get(),
        ]);
    }
}
