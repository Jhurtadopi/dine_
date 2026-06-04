<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->isAdmin() || $user->isWaiter()) {
            return redirect()->route('tables.index');
        }

        return redirect()->route('login')->withErrors([
            'email' => 'Tu rol no tiene módulos activos en este incremento.',
        ]);
    }
}
