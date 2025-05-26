<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Fetch pengajuans for the authenticated user
        $query = Pengajuan::where('user_id', Auth::id());

        // Apply search filter if provided
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('tingkat', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('catatan', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');
        $query->orderBy($sort, $direction);

        // Paginate the results
        $pengajuans = $query->paginate(5)->withQueryString();

        // Return the Inertia response
        return inertia('Dashboard', [
            'auth' => [
                'user' => auth()->user(),
            ],
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
        ]);
    }

    public function track(Request $request)
    {
        // Search for a specific pengajuan by name
        $search = trim($request->input('search'));

        $pengajuan = Pengajuan::where('user_id', Auth::id())
            ->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
            ->first();

        // Fetch the list of pengajuans for the table
        $query = Pengajuan::where('user_id', Auth::id());

        // Apply search filter for the table (if any)
        if ($request->has('search')) {
            $tableSearch = $request->input('search');
            $query->where(function ($q) use ($tableSearch) {
                $q->where('nama', 'like', "%{$tableSearch}%")
                    ->orWhere('tingkat', 'like', "%{$tableSearch}%")
                    ->orWhere('status', 'like', "%{$tableSearch}%")
                    ->orWhere('catatan', 'like', "%{$tableSearch}%");
            });
        }

        // Apply sorting for the table
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');
        $query->orderBy($sort, $direction);

        // Paginate the results for the table
        $pengajuans = $query->paginate(5)->withQueryString();

        // Return the Inertia response
        return inertia('Dashboard', [
            'auth' => [
                'user' => auth()->user(),
            ],
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
        ]);
    }
}
