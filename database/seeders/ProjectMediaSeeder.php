<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();

        if ($projects->isEmpty()) {
            return;
        }

        $mediaNames = [
            'screenshot-1.png',
            'screenshot-2.png',
            'demo-video.mp4',
            'architecture-diagram.png',
            'ui-mockup.png',
            'team-photo.jpg',
            'presentation.pdf',
            'demo-preview.png',
            'feature-overview.png',
            'mobile-screenshot.png',
        ];

        // Add 1-3 media files to each project
        foreach ($projects as $project) {
            $mediaCount = random_int(1, 3);
            $selectedMedia = array_rand($mediaNames, min($mediaCount, count($mediaNames)));
            $selectedMedia = is_array($selectedMedia) ? $selectedMedia : [$selectedMedia];
            
            foreach ($selectedMedia as $index) {
                DB::table('project_media')->insert([
                    'project_id' => $project->id,
                    'medianame' => $mediaNames[$index],
                    'file_path'  => 'media/demo-video.mp4', // add this
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
