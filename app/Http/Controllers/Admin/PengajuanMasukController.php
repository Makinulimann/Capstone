<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class PengajuanMasukController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Pengajuan::with('user')
            ->where('status', 'diproses_admin')
            ->select('id', 'user_id', 'nama', 'tingkat', 'status', 'created_at', 'updated_at', 'catatan')
            ->when($request->search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('tingkat', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('nidn', 'like', "%{$search}%")
                            ->orWhere('department', 'like', "%{$search}%");
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
            $query->orderBy('title', $direction); // Assuming title is nama_kegiatan
        } else {
            $query->orderBy($sort, $direction);
        }

        $pengajuans = $query->paginate(10)->withQueryString();

        return Inertia::render('admin/Pengajuan', [
            'pengajuans' => $pengajuans->through(function ($item) {
                return [
                    'id' => $item->id,
                    'tanggal_pengajuan' => $item->created_at->format('Y-m-d H:i:s'),
                    'nama' => $item->user->name ?? 'Unknown',
                    'nidn' => $item->user->nidn ?? '-',
                    'department' => $item->user->department ?? '-',
                    'nama_kegiatan' => $item->nama ?? '-', // Map title to nama_kegiatan
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
}
