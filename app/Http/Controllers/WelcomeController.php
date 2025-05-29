<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class WelcomeController extends Controller
{
    public function index(): Response
    {
        $totalUsers = User::count();
        $totalPengajuan = Pengajuan::count();

        Log::info('Welcome page data', [
            'totalUsers' => $totalUsers,
            'totalPengajuan' => $totalPengajuan,
        ]);

        return Inertia::render('Welcome', [
            'totalUsers' => $totalUsers,
            'totalPengajuan' => $totalPengajuan,
        ]);
    }
}
