<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(Request $request): Response
    {
        // --- Users Data ---
        $allUsers = User::select('id', 'name', 'email', 'role')->get();
        $paginatedUsers = User::select('id', 'name', 'email', 'role')
            ->paginate(10, ['*'], 'users_page')
            ->withQueryString();

        // --- Pengajuan Data ---
        $queryPengajuans = Pengajuan::with(['user' => function ($query) {
            $query->select('id', 'name', 'nidn', 'department', 'email');
        }])
            ->select(
                'pengajuans.id',
                'pengajuans.user_id',
                'pengajuans.nama as activity_title',
                'pengajuans.tingkat',
                'pengajuans.status',
                'pengajuans.created_at',
                'pengajuans.updated_at',
                'pengajuans.catatan'
            );

        // Sorting logic
        $sortPengajuan = $request->input('sort_pengajuan', 'created_at');
        $directionPengajuan = $request->input('direction_pengajuan', 'desc');

        if ($sortPengajuan === 'nama') {
            $queryPengajuans->join('users', 'pengajuans.user_id', '=', 'users.id')
                ->orderBy('users.name', $directionPengajuan)
                ->select('pengajuans.*');
        } elseif (in_array($sortPengajuan, ['nidn', 'department'])) {
            $queryPengajuans->join('users', 'pengajuans.user_id', '=', 'users.id')
                ->orderBy('users.' . $sortPengajuan, $directionPengajuan)
                ->select('pengajuans.*');
        } elseif ($sortPengajuan === 'title') {
            $queryPengajuans->orderBy('pengajuans.nama', $directionPengajuan);
        } elseif (in_array($sortPengajuan, ['created_at', 'status', 'updated_at', 'tingkat'])) {
            $queryPengajuans->orderBy('pengajuans.' . $sortPengajuan, $directionPengajuan);
        } else {
            $queryPengajuans->orderBy('pengajuans.created_at', $directionPengajuan);
        }

        $paginatedPengajuans = $queryPengajuans->paginate(5, ['*'], 'pengajuan_page')->withQueryString();

        $transformedPengajuans = $paginatedPengajuans->through(function ($item) {
            return [
                'id' => $item->id,
                'created_at' => $item->created_at->toIso8601String(),
                'nama' => $item->user->name ?? 'Unknown',
                'user' => [
                    'nidn' => $item->user->nidn ?? null,
                    'department' => $item->user->department ?? null,
                    'name' => $item->user->name ?? 'Unknown',
                    'email' => $item->user->email ?? '',
                ],
                'title' => $item->activity_title ?? '-',
                'tingkat' => $item->tingkat,
                'status' => $item->status,
                'updated_at' => $item->updated_at->toIso8601String(),
                'catatan' => $item->catatan ?? null,
            ];
        });

        // --- Pengajuan by Month (current year) ---
        $pengajuanByMonth = Pengajuan::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // Create an array of 12 months, filled with 0
        $months = array_fill(0, 12, 0);
        // Map query results to the correct month index (0-based for array)
        foreach ($pengajuanByMonth as $month => $count) {
            $months[$month - 1] = $count; // Adjust month (1-12) to array index (0-11)
        }

        // --- Pengajuan by Status ---
        $pengajuanByStatus = Pengajuan::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Get the authenticated user and their role
        $user = auth()->user();
        $userRole = $user ? $user->role : null;

        return Inertia::render('admin/DashboardAdmin', [
            'auth' => [
                'user' => $user,
                'role' => $userRole, // Explicitly pass the role
            ],
            'users' => $paginatedUsers,
            'paginationUsers' => [
                'current_page' => $paginatedUsers->currentPage(),
                'last_page' => $paginatedUsers->lastPage(),
                'from' => $paginatedUsers->firstItem(),
                'to' => $paginatedUsers->lastItem(),
                'total' => $paginatedUsers->total(),
                'links' => $paginatedUsers->linkCollection()->toArray(),
            ],
            'usersSummary' => [
                'total' => $allUsers->count(),
                'admins' => $allUsers->where('role', 'admin')->count(),
                'dosens' => $allUsers->where('role', 'dosen')->count(),
                'kepalaUnits' => $allUsers->where('role', 'kepala_unit')->count(),
                'wakilDekans' => $allUsers->where('role', 'wakil_dekan')->count(),
            ],
            'pengajuans' => $transformedPengajuans,
            'paginationPengajuans' => [
                'current_page' => $paginatedPengajuans->currentPage(),
                'last_page' => $paginatedPengajuans->lastPage(),
                'from' => $paginatedPengajuans->firstItem(),
                'to' => $paginatedPengajuans->lastItem(),
                'total' => $paginatedPengajuans->total(),
                'links' => $paginatedPengajuans->linkCollection()->toArray(),
            ],
            'sortPengajuan' => $sortPengajuan,
            'directionPengajuan' => $directionPengajuan,
            'pengajuanByMonth' => $months,
            'pengajuanByStatus' => $pengajuanByStatus,
        ]);
    }

    public function users(Request $request): Response
    {
        $query = User::select('id', 'name', 'email', 'role')
            ->when($request->search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });

        $users = $query->paginate(10)->withQueryString();

        return Inertia::render('admin/Users', [
            'users' => $users,
            'pagination' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem(),
                'total' => $users->total(),
            ],
            'search' => $request->search ?? '',
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(['role' => $request->input('role')]);
        return redirect()->back()->with('success', 'Role updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully');
    }
}