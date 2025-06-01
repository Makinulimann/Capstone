<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\PengajuanStatusHistory;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Notifications\PengajuanStatusUpdated;

class PengajuanMasukController extends Controller
{
    public function index(Request $request): Response
    {
        $userRole = Auth::user()->role;
        $statusFilter = match ($userRole) {
            'admin' => 'diproses_admin',
            'kepala_unit' => 'verifikasi_ku',
            'wakil_dekan' => 'pengesahan',
            default => abort(403, 'Unauthorized role for this page.'),
        };

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
            'auth' => ['user' => Auth::user(), 'role' => $userRole],
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
            'auth' => ['user' => Auth::user(), 'role' => $userRole],
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

        $allowedStatuses = [
            'admin' => ['diproses_admin', 'verifikasi_ku', 'ditolak'],
            'kepala_unit' => ['verifikasi_ku', 'pengesahan', 'ditolak'],
            'wakil_dekan' => ['pengesahan', 'disetujui', 'ditolak'],
        ];

        $rules = [
            'status' => ['required', 'in:' . implode(',', $allowedStatuses[$userRole])],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ];

        $rules['catatan'][] = $request->status === 'ditolak' ? 'required' : 'nullable';
        if ($userRole === 'admin' && $request->status === 'verifikasi_ku') {
            $rules['anggaran'] = ['required', 'integer', 'min:1'];
        }
        if ($userRole === 'wakil_dekan' && $request->status === 'disetujui') {
            $rules['proposal'] = ['required', 'file', 'mimes:pdf,doc,docx', 'max:2048'];
        }

        try {
            $validatedData = $request->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed for pengajuan update', [
                'errors' => $e->errors(),
                'request' => $request->all(),
                'user_id' => Auth::id(),
                'role' => $userRole,
            ]);
            throw $e;
        }

        $pengajuan = Pengajuan::findOrFail($id);
        $originalStatus = $pengajuan->status;
        $pengajuan->status = $validatedData['status'];
        $pengajuan->catatan = $validatedData['catatan'] ?? $pengajuan->catatan;

        if (isset($validatedData['anggaran'])) {
            $pengajuan->anggaran = $validatedData['anggaran'];
        }

        // Handle proposal upload and replace existing file
        if ($request->hasFile('proposal')) {
            // Delete the old proposal file if it exists
            if ($pengajuan->proposal && file_exists(storage_path('app/public/' . $pengajuan->proposal))) {
                unlink(storage_path('app/public/' . $pengajuan->proposal));
            }

            $file = $request->file('proposal');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('proposals', $fileName, 'public');
            $pengajuan->proposal = 'proposals/' . $fileName;
        }

        $pengajuan->save();

        if ($originalStatus !== $validatedData['status']) {
            PengajuanStatusHistory::create([
                'pengajuan_id' => $id,
                'user_id' => Auth::id(),
                'role' => $userRole,
                'status' => $validatedData['status'],
                'catatan' => $validatedData['catatan'],
                'anggaran' => $validatedData['anggaran'] ?? null,
            ]);
        }

        Log::info('Pengajuan updated', [
            'id' => $id,
            'status' => $validatedData['status'],
            'catatan' => $validatedData['catatan'] ?? null,
            'anggaran' => $validatedData['anggaran'] ?? null,
            'proposal' => $request->hasFile('proposal') ? $fileName : $pengajuan->proposal,
            'user_id' => Auth::id(),
            'role' => $userRole,
        ]);

        $pengajuan->user->notify(new PengajuanStatusUpdated($pengajuan, $validatedData['status'], $validatedData['catatan']));

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