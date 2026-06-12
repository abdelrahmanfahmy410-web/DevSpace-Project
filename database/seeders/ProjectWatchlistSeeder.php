<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectWatchlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $users = User::all();

        if ($projects->isEmpty() || $users->isEmpty()) {
            return;
        }

        // Have 20-60% of users add each project to their watchlist
        foreach ($projects as $project) {
            $watchlistCount = random_int(
                max(1, intdiv($users->count(), 5)),
                intdiv($users->count() * 3, 5)
            );
            
            $usersToAdd = $users->random(min($watchlistCount, $users->count()))->pluck('id')->unique();
            
            foreach ($usersToAdd as $userId) {
                DB::table('project_user_watchlist')->updateOrInsert(
                    [
                        'project_id' => $project->id,
                        'user_id' => $userId,
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
