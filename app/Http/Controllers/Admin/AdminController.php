<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index(): Response
    {
        $users = User::select('id', 'name', 'email', 'role')->get();

        return Inertia::render('admin/DashboardAdmin', [
            'auth' => [
                'user' => auth()->user(),
            ],
            'usersSummary' => [
                'total' => $users->count(),
                'admins' => $users->where('role', 'admin')->count(),
                'dosens' => $users->where('role', 'dosen')->count(),
                'kepalaUnits' => $users->where('role', 'kepala_unit')->count(),
                'wakilDekans' => $users->where('role', 'wakil_dekan')->count(),
            ],
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
            'search' => $request->search ?? '', // Pass the search term back to the frontend
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
