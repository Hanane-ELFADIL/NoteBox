<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Note;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Administrateur',
            'email' => 'admin@notebox.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Create demo user
        $user = User::create([
            'name' => 'Utilisateur Demo',
            'email' => 'demo@notebox.com',
            'password' => Hash::make('password'),
        ]);

        // Create categories for demo user
        $categories = [
            ['name' => 'Personnel', 'color' => '#ff6b6b', 'user_id' => $user->id],
            ['name' => 'Travail', 'color' => '#4ecdc4', 'user_id' => $user->id],
            ['name' => 'Idées', 'color' => '#45b7d1', 'user_id' => $user->id],
            ['name' => 'Urgent', 'color' => '#f9ca24', 'user_id' => $user->id],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Create demo notes
        $notes = [
            [
                'title' => 'Bienvenue dans NoteBox !',
                'content' => 'Ceci est votre première note. Vous pouvez la modifier, la supprimer ou en créer de nouvelles. NoteBox vous aide à organiser toutes vos idées en un seul endroit.',
                'user_id' => $user->id,
                'category_id' => 1,
                'is_favorite' => true,
            ],
            [
                'title' => 'Liste de courses',
                'content' => "- Lait\n- Pain\n- Œufs\n- Fromage\n- Pommes\n- Yaourts",
                'user_id' => $user->id,
                'category_id' => 1,
            ],
            [
                'title' => 'Réunion équipe',
                'content' => 'Préparer la présentation pour la réunion de demain. Points à aborder : budget, planning, ressources nécessaires.',
                'user_id' => $user->id,
                'category_id' => 2,
                'reminder_date' => now()->addDay(),
            ],
            [
                'title' => 'Idée d\'application',
                'content' => 'Développer une application de gestion de tâches avec intelligence artificielle pour prioriser automatiquement les tâches.',
                'user_id' => $user->id,
                'category_id' => 3,
                'is_favorite' => true,
            ],
        ];

        foreach ($notes as $noteData) {
            Note::create($noteData);
        }
    }
}
