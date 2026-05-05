<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->notes()->with('category');

        // Recherche
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        // Filtres
        if ($request->filter) {
            switch ($request->filter) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'favorites':
                    $query->where('is_favorite', true);
                    break;
            }
        }

        // Catégorie
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $notes = $query->orderBy('created_at', 'desc')->paginate(12);
        $categories = Auth::user()->categories;

        return view('notes.index', compact('notes', 'categories'));
    }

    public function create()
    {
        $categories = Auth::user()->categories;
        return view('notes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'reminder_date' => 'nullable|date|after:now',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['is_favorite'] = $request->has('is_favorite');

        Note::create($data);

        return redirect()->route('notes.index')->with('success', 'Note créée avec succès!');
    }

    public function show(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }
        return view('notes.show', compact('note'));
    }

    public function edit(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }
        $categories = Auth::user()->categories;
        return view('notes.edit', compact('note', 'categories'));
    }

    public function update(Request $request, Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'reminder_date' => 'nullable|date|after:now',
        ]);

        $data = $request->all();
        $data['is_favorite'] = $request->has('is_favorite');

        $note->update($data);

        return redirect()->route('notes.index')->with('success', 'Note mise à jour avec succès!');
    }

    public function destroy(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }
        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Note supprimée avec succès!');
    }

    public function toggleFavorite(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }
        $note->update(['is_favorite' => !$note->is_favorite]);

        return back()->with('success', 'Favori mis à jour!');
    }

    public function calendar()
    {
        $notes = Auth::user()->notes()->whereNotNull('reminder_date')->with('category')->get();
        return view('notes.calendar', compact('notes'));
    }
}
