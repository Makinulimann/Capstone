<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class PengajuanController extends Controller
{
    public function create()
    {
        if (Auth::user()->role !== 'dosen') {
            abort(403, 'Only dosen role can access this page.');
        }

        return inertia('Pengajuan');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'dosen') {
            return response()->json(['message' => 'Only dosen role can submit this form.'], 403);
        }

        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'tingkat' => 'nullable|string|max:255',
            'lokasi' => 'required|string|max:255',
            'kategori' => 'required|in:Pemohonan,Reimburse',
            'periodeMulai' => 'nullable|date',
            'periodeSelesai' => 'nullable|date|after_or_equal:periodeMulai',
            'deskripsi' => 'required|string',
            'proposal' => 'nullable|file|mimes:pdf|max:2048',
            'bukti' => 'nullable|file|mimes:pdf|max:2048|required_if:kategori,Reimburse',
        ]);

        $pengajuan = new Pengajuan();
        $pengajuan->user_id = Auth::id();
        $pengajuan->nama = $validatedData['nama'];
        $pengajuan->tingkat = $validatedData['tingkat'];
        $pengajuan->lokasi = $validatedData['lokasi'];
        $pengajuan->kategori = $validatedData['kategori'];
        $pengajuan->periodeMulai = $validatedData['periodeMulai'];
        $pengajuan->periodeSelesai = $validatedData['periodeSelesai'];
        $pengajuan->deskripsi = $validatedData['deskripsi'];
        $pengajuan->status = 'diproses_admin';

        if ($request->hasFile('proposal')) {
            $pengajuan->proposal = $request->file('proposal')->store('pengajuans/proposals', 'public');
        }

        if ($request->hasFile('bukti') && $validatedData['kategori'] === 'Reimburse') {
            $pengajuan->bukti = $request->file('bukti')->store('pengajuans/buktis', 'public');
        }

        $pengajuan->save();

        return redirect()->route('pengajuan.create')->with('success', 'Pengajuan submitted successfully.');
    }

    public function index(Request $request): Response
    {
        if (Auth::user()->role !== 'dosen') {
            abort(403, 'Only dosen role can access this page.');
        }

        $query = Pengajuan::where('user_id', Auth::id())
            ->select('id', 'nama', 'tingkat', 'status', 'created_at', 'updated_at', 'catatan')
            ->when($request->search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhere('tingkat', 'like', "%{$search}%");
            });

        // Apply sorting
        $sort = $request->sort ?? 'created_at';
        $direction = $request->direction ?? 'desc';
        if ($sort === 'nama_kegiatan') {
            $query->orderBy('nama', $direction); // Using 'nama' instead of 'title'
        } else {
            $query->orderBy($sort, $direction);
        }

        $pengajuans = $query->paginate(10)->withQueryString();

        // Log for debugging
        Log::info('Pengajuan index data', ['pengajuans' => $pengajuans->items(), 'total' => $pengajuans->total()]);

        return Inertia::render('Sertifikasi', [ // Changed to 'Pengajuan' view
            'pengajuans' => $pengajuans->through(function ($item) {
                return [
                    'id' => $item->id,
                    'tanggal_pengajuan' => $item->created_at->format('Y-m-d H:i:s'),
                    'nama_kegiatan' => $item->nama ?? '-',
                    'tingkat' => $item->tingkat ?? 'N/A',
                    'status' => $item->status,
                    'last_update' => $item->updated_at->format('Y-m-d H:i:s'),
                    'catatan' => $item->catatan ?? null,
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

    public function track(Request $request)
    {
        $search = trim($request->input('search', '')); // Pastikan ada default value
        Log::info('Tracking search term:', [
            'search' => $search,
            'user_id' => Auth::id(),
            'search_length' => strlen($search)
        ]);

        $pengajuan = null;

        if (!empty($search)) {
            // Coba berbagai variasi pencarian
            $pengajuan = Pengajuan::where('user_id', Auth::id())
                ->where(function ($query) use ($search) {
                    $query->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('nama LIKE ?', ['%' . $search . '%'])
                        ->orWhere('nama', 'LIKE', "%{$search}%");
                })
                ->first();

            // Debug: Log semua pengajuan user untuk debugging
            $allPengajuans = Pengajuan::where('user_id', Auth::id())->pluck('nama');
            Log::info('All user pengajuans:', ['pengajuans' => $allPengajuans]);
        }

        if (!$pengajuan && !empty($search)) {
            Log::warning('No pengajuan found for search term:', [
                'search' => $search,
                'user_id' => Auth::id()
            ]);
        }

        return inertia('Dashboard', [
            'pengajuan' => $pengajuan ? [
                'id' => $pengajuan->id,
                'nama' => $pengajuan->nama,
                'nama_kegiatan' => $pengajuan->nama_kegiatan,
                'status' => $pengajuan->status,
                'catatan' => $pengajuan->catatan ?? '-',
            ] : null,
        ]);
    }
}