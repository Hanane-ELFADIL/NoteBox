<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Auth::user()->categories()->withCount('notes')->get();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        Category::create($data);

        return back()->with('success', 'Catégorie créée avec succès!');
    }

    public function update(Request $request, Category $category)
    {
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|max:255',
            'color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $category->update($request->all());

        return back()->with('success', 'Catégorie mise à jour avec succès!');
    }

    public function destroy(Category $category)
    {
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }
        $category->delete();

        return back()->with('success', 'Catégorie supprimée avec succès!');
    }
}
