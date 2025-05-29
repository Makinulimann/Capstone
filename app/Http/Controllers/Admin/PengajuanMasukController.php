<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PengajuanMasukController extends Controller
{
    public function index(Request $request): Response
    {
        // Determine the status filter based on the user's role
        $userRole = Auth::user()->role;
        $statusFilter = match ($userRole) {
            'admin' => 'diproses_admin',
            'kepala_unit' => 'verifikasi_ku',
            'wakil_dekan' => 'pengesahan',
            default => abort(403, 'Unauthorized role for this page.'),
        };

        // Log the status filter for debugging
        Log::info('Fetching pengajuan data for role', [
            'role' => $userRole,
            'status_filter' => $statusFilter,
        ]);

        $query = Pengajuan::with('user')
            ->where('status', $statusFilter)
            ->select('id', 'user_id', 'nama', 'tingkat', 'status', 'created_at', 'updated_at', 'catatan')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('nama', 'like', "%{$search}%")
                        ->orWhere('tingkat', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('nidn', 'like', "%{$search}%")
                                ->orWhere('department', 'like', "%{$search}%");
                        });
                });
            });

        // Apply sorting
        $sort = $request->sort ?? 'created_at';
        $direction = $request->direction ?? 'desc';
        if ($sort === 'nama') {
            $query->join('users', 'pengajuans.user_id', '=', 'users.id')
                ->orderBy('users.name', $direction)
                ->select('pengajuans.*');
        } elseif (in_array($sort, ['nidn', 'department'])) {
            $query->join('users', 'pengajuans.user_id', '=', 'users.id')
                ->orderBy("users.{$sort}", $direction)
                ->select('pengajuans.*');
        } elseif ($sort === 'nama_kegiatan') {
            $query->orderBy('nama', $direction);
        } else {
            $query->orderBy($sort, $direction);
        }

        $pengajuans = $query->paginate(10)->withQueryString();

        return Inertia::render('admin/Pengajuan', [
            'auth' => [
                'user' => Auth::user(),
                'role' => $userRole,
            ],
            'pengajuans' => $pengajuans->through(function ($item) {
                return [
                    'id' => $item->id,
                    'tanggal_pengajuan' => $item->created_at->format('Y-m-d H:i:s'),
                    'nama' => $item->user->name ?? 'Unknown',
                    'nidn' => $item->user->nidn ?? '-',
                    'department' => $item->user->department ?? '-',
                    'nama_kegiatan' => $item->nama ?? '-',
                    'status' => $item->status,
                    'last_update' => $item->updated_at->format('Y-m-d H:i:s'),
                    'catatan' => $item->catatan ?? '-',
                ];
            }),
            'pagination' => [
                'current_page' => $pengajuans->currentPage(),
                'last_page' => $pengajuans->lastPage(),
                'from' => $pengajuans->firstItem(),
                'to' => $pengajuans->lastItem(),
                'total' => $pengajuans->total(),
            ],
            'search' => $request->search ?? '',
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    public function show($id): Response
    {
        $userRole = Auth::user()->role;
        $allowedRoles = ['admin', 'kepala_unit', 'wakil_dekan'];
        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Only admin, kepala_unit, or wakil_dekan roles can access this page.');
        }

        $pengajuan = Pengajuan::with('user')->findOrFail($id);

        return Inertia::render('admin/PengajuanDetail', [
            'auth' => [
                'user' => Auth::user(),
                'role' => $userRole,
            ],
            'pengajuan' => [
                'id' => $pengajuan->id,
                'nama' => $pengajuan->nama,
                'tingkat' => $pengajuan->tingkat ?? 'N/A',
                'lokasi' => $pengajuan->lokasi,
                'kategori' => $pengajuan->kategori,
                'periodeMulai' => $pengajuan->periodeMulai?->format('Y-m-d'),
                'periodeSelesai' => $pengajuan->periodeSelesai?->format('Y-m-d'),
                'deskripsi' => $pengajuan->deskripsi,
                'status' => $pengajuan->status,
                'catatan' => $pengajuan->catatan ?? '-',
                'proposal' => $pengajuan->proposal ? asset('storage/' . $pengajuan->proposal) : null,
                'bukti' => $pengajuan->bukti ? asset('storage/' . $pengajuan->bukti) : null,
                'anggaran' => $pengajuan->anggaran ?? 0,
                'user' => [
                    'name' => $pengajuan->user->name,
                    'nidn' => $pengajuan->user->nidn,
                    'department' => $pengajuan->user->department,
                ],
                'created_at' => $pengajuan->created_at->format('Y-m-d H:i'),
                'updated_at' => $pengajuan->updated_at->format('Y-m-d H:i'),
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $userRole = Auth::user()->role;
        $allowedRoles = ['admin', 'kepala_unit', 'wakil_dekan'];
        if (!in_array($userRole, $allowedRoles)) {
            return response()->json(['message' => 'Unauthorized role to update status.'], 403);
        }

        // Define allowed statuses for each role
        $allowedStatuses = [
            'admin' => ['diproses_admin', 'verifikasi_ku', 'ditolak'],
            'kepala_unit' => ['verifikasi_ku', 'pengesahan', 'ditolak'],
            'wakil_dekan' => ['pengesahan', 'disetujui', 'ditolak'],
        ];

        // Validation rules
        $rules = [
            'status' => ['required', 'in:' . implode(',', $allowedStatuses[$userRole])],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ];

        // Add conditional validation for anggaran and catatan
        $rules['catatan'][] = $request->status === 'ditolak' ? 'required' : 'nullable';
        if ($userRole === 'admin' && $request->status === 'verifikasi_ku') {
            $rules['anggaran'] = ['required', 'integer', 'min:1'];
        }

        $validatedData = $request->validate($rules);

        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->status = $validatedData['status'];
        $pengajuan->catatan = $validatedData['catatan'] ?? $pengajuan->catatan;

        // Update anggaran if provided (for admin role)
        if (isset($validatedData['anggaran'])) {
            $pengajuan->anggaran = $validatedData['anggaran'];
        }

        $pengajuan->save();

        Log::info('Pengajuan updated', [
            'id' => $id,
            'status' => $validatedData['status'],
            'catatan' => $validatedData['catatan'] ?? null,
            'anggaran' => $validatedData['anggaran'] ?? null,
            'user_id' => Auth::id(),
            'role' => $userRole,
        ]);

        // Redirect to the pengajuan list page
        return redirect()->route('admin.pengajuan')->with('success', 'Status updated successfully.');
    }

    public function addNote(Request $request, $id)
    {
        $userRole = Auth::user()->role;
        $allowedRoles = ['admin', 'kepala_unit', 'wakil_dekan'];
        if (!in_array($userRole, $allowedRoles)) {
            return response()->json(['message' => 'Unauthorized role to add notes.'], 403);
        }

        $validatedData = $request->validate([
            'catatan' => 'nullable|string|max:1000',
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->catatan = $validatedData['catatan'] ?? $pengajuan->catatan;
        $pengajuan->save();

        Log::info('Pengajuan note added', ['id' => $id, 'catatan' => $validatedData['catatan'], 'user_id' => Auth::id()]);

        return redirect()->back()->with('success', 'Note added successfully.');
    }
}