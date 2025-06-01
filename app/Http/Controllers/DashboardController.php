<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\PengajuanStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengajuan::where('user_id', Auth::id());

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('tingkat', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('catatan', 'like', "%{$search}%");
            });
        }

        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');
        $query->orderBy($sort, $direction);

        $pengajuans = $query->paginate(5)->withQueryString();

        $latestStatusUpdate = PengajuanStatusHistory::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->first();

        return inertia('Dashboard', [
            'auth' => ['user' => auth()->user()],
            'pengajuans' => $pengajuans->map(function ($item) {
                return [
                    'id' => $item->id,
                    'tanggal_pengajuan' => $item->created_at->format('Y-m-d H:i:s'),
                    'nama' => $item->nama,
                    'tingkat' => $item->tingkat ?? 'N/A',
                    'status' => $item->status,
                    'last_update' => $item->updated_at->format('Y-m-d H:i:s'),
                    'catatan' => $item->catatan ?? '-',
                ];
            }),
            'pagination' => [
                'current_page' => $pengajuans->currentPage(),
                'last_page' => $pengajuans->lastPage(),
                'per_page' => $pengajuans->perPage(),
                'total' => $pengajuans->total(),
                'from' => $pengajuans->firstItem(),
                'to' => $pengajuans->lastItem(),
            ],
            'search' => $request->input('search', ''),
            'sort' => $sort,
            'direction' => $direction,
            'latestStatusUpdate' => $latestStatusUpdate ? [
                'pengajuan_id' => $latestStatusUpdate->pengajuan_id,
                'role' => $latestStatusUpdate->role,
                'status' => $latestStatusUpdate->status,
                'catatan' => $latestStatusUpdate->catatan,
                'anggaran' => $latestStatusUpdate->anggaran,
                'updated_at' => $latestStatusUpdate->updated_at->format('Y-m-d H:i'),
            ] : null,
        ]);
    }

    // Ensure track method is consistent if used
    public function track(Request $request)
    {
        $search = trim($request->input('search'));

        $pengajuan = Pengajuan::where('user_id', Auth::id())
            ->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
            ->first();

        $query = Pengajuan::where('user_id', Auth::id());

        if ($request->has('search')) {
            $tableSearch = $request->input('search');
            $query->where(function ($q) use ($tableSearch) {
                $q->where('nama', 'like', "%{$tableSearch}%")
                    ->orWhere('tingkat', 'like', "%{$tableSearch}%")
                    ->orWhere('status', 'like', "%{$tableSearch}%")
                    ->orWhere('catatan', 'like', "%{$tableSearch}%");
            });
        }

        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');
        $query->orderBy($sort, $direction);

        $pengajuans = $query->paginate(5)->withQueryString();

        $latestStatusUpdate = PengajuanStatusHistory::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->first();

        return inertia('Dashboard', [
            'auth' => ['user' => auth()->user()],
            'pengajuan' => $pengajuan ? [
                'id' => $pengajuan->id,
                'nama' => $pengajuan->nama,
                'status' => $pengajuan->status,
                'catatan' => $pengajuan->catatan ?? '-',
            ] : null,
            'pengajuans' => $pengajuans->items(),
            'pagination' => [
                'current_page' => $pengajuans->currentPage(),
                'last_page' => $pengajuans->lastPage(),
                'per_page' => $pengajuans->perPage(),
                'total' => $pengajuans->total(),
                'from' => $pengajuans->firstItem(),
                'to' => $pengajuans->lastItem(),
            ],
            'search' => $request->input('search', ''),
            'sort' => $sort,
            'direction' => $direction,
            'latestStatusUpdate' => $latestStatusUpdate ? [
                'pengajuan_id' => $latestStatusUpdate->pengajuan_id,
                'role' => $latestStatusUpdate->role,
                'status' => $latestStatusUpdate->status,
                'catatan' => $latestStatusUpdate->catatan,
                'anggaran' => $latestStatusUpdate->anggaran,
                'updated_at' => $latestStatusUpdate->updated_at->format('Y-m-d H:i'),
            ] : null,
        ]);
    }
}