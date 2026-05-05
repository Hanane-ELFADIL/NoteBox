<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Note;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_notes' => Note::count(),
            'notes_today' => Note::whereDate('created_at', today())->count(),
            'notes_this_week' => Note::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];

        $recent_users = User::latest()->take(5)->get();
        $recent_notes = Note::with('user')->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_notes'));
    }

    public function users()
    {
        $users = User::withCount('notes')->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function destroyUser(User $user)
    {
        if ($user->is_admin) {
            return back()->with('error', 'Impossible de supprimer un administrateur!');
        }

        $user->delete();
        return back()->with('success', 'Utilisateur supprimé avec succès!');
    }
}
