<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // ── Featured Projects ────────────────────────────────────────
        $featuredProjects = Project::with([
            'specializations',
            'team_roles',
        ])
            ->select('id', 'title', 'description', 'type', 'views', 'created_at')
            ->latest()
            ->take(6)
            ->get()
            ->map(function (Project $project) {

                $colours = ['green', 'blue', 'amber', 'coral', 'purple', 'teal'];
                $emojis = ['🚀', '💡', '🌿', '🔧', '📚', '🤖', '🔋', '💊', '🎯', '💳'];
                $color = $colours[$project->id % count($colours)];
                $emoji = $emojis[$project->id % count($emojis)];

                // Normalise whatever the DB stores → a consistent slug
                $typeRaw = strtolower(trim($project->type ?? 'idea'));
                $typeNorm = str_replace([' ', '_'], '-', $typeRaw);

                // Badge slug used for data-stage and filter matching
                $badgeMap = [
                    'idea' => 'idea',
                    'prototype' => 'prototype',
                    'mvp' => 'mvp',
                    'market-ready' => 'market-ready',
                ];
                $badge = $badgeMap[$typeNorm] ?? 'idea';

                // CSS type class used for card accent colour
                $typeClassMap = [
                    'idea' => 'web',
                    'prototype' => 'mobile',
                    'mvp' => 'ai',
                    'market-ready' => 'security',
                ];
                $typeClass = $typeClassMap[$badge] ?? 'web';

                // Human-readable stage label
                $stageLabel = match ($badge) {
                    'idea' => 'Idea',
                    'prototype' => 'Prototype',
                    'mvp' => 'MVP',
                    'market-ready' => 'Market Ready',
                    default => ucfirst(str_replace('-', ' ', $badge)),
                };

                // Sectors from specializations relation
                $sectors = $project->specializations->map(fn ($s) => [
                    'id' => $s->id,
                    'name' => $s->name,
                ])->take(3)->toArray();

                // All specialization IDs for filter matching
                $specializationIds = $project->specializations->pluck('id')->toArray();

                // Team avatars — initials of first 3 members
                $teamAvatars = $project->team_roles
                    ->take(3)
                    ->map(fn ($member) => strtoupper(substr($member->name ?? '?', 0, 2)))
                    ->toArray();

                return [
                    'id' => $project->id,
                    'emoji' => $emoji,
                    'color' => $color,
                    'stage' => $stageLabel,
                    'badge' => $badge,
                    'type' => $typeClass,
                    'sectors' => $sectors,
                    'specializationIds' => $specializationIds,
                    'title' => $project->title,
                    'tagline' => $project->description,
                    'team' => $teamAvatars,
                    'members' => $project->team_roles->count(),
                    'views' => ($project->views ?? 0).' views',
                ];
            });

        // ── Mentors ──────────────────────────────────────────────────
        $mentorAvatarStyles = [
            '',
            'background:#eef3ff; color:#3B5BDB;',
            'background:#fff8e1; color:#B45309;',
            'background:#fdecea; color:#C0392B;',
        ];

       $mentors = User::whereHas('roles', fn($q) => $q->where('name', 'mentor'))
    ->with(['roles', 'mentor.specialization'])  // ← load mentor → specialization
    ->take(5)
    ->get()
    ->values()
    ->map(function (User $user, int $index) use ($mentorAvatarStyles) {
        $title = $user->job_title ?? 'Mentor';
        $spec  = $user->mentor?->specialization?->name;

        return [
            'initials'        => strtoupper(substr($user->name, 0, 2)),
            'name'            => $user->name,
            'title'           => $title,
            'specializations' => $spec ? [$spec] : [],
            'style'           => $mentorAvatarStyles[$index % count($mentorAvatarStyles)],
            'id'              => $user->id,
        ];
    });

        // ── Testimonials ─────────────────────────────────────────────
        $testimonialStyles = [
            '',
            'background:#eef3ff; color:#3B5BDB;',
            'background:#fff8e1; color:#B45309;',
        ];

        try {
            $testimonials = User::whereNotNull('testimonial')
                ->where('testimonial', '!=', '')
                ->take(3)
                ->get()
                ->values()
                ->map(function (User $user, int $index) use ($testimonialStyles) {
                    return [
                        'quote' => $user->testimonial,
                        'name' => $user->name,
                        'role' => $user->job_title ?? 'DevSpace Member',
                        'avatar' => strtoupper(substr($user->name, 0, 2)),
                        'style' => $testimonialStyles[$index % count($testimonialStyles)],
                    ];
                });
        } catch (\Exception $e) {
            $testimonials = collect([]);
        }

        if ($testimonials->isEmpty()) {
            $testimonials = collect($this->fallbackTestimonials());
        }

        // ── Specializations (top used, for filter pills) ─────────────
        $specializations = Specialization::withCount('projects')
            ->having('projects_count', '>', 0)
            ->orderByDesc('projects_count')
            ->take(6)
            ->get(['id', 'name']);

        // ── Stats ────────────────────────────────────────────────────
        $projectCount = Project::count();
        $mentorCount = User::whereHas('roles', fn ($q) => $q->where('name', 'mentor'))->count();
        $investorCount = User::whereHas('roles', fn ($q) => $q->where('name', 'investor'))->count();

        $developerCount = User::whereHas('roles', fn ($q) => $q->where('name', 'developer'))->count();

        $stats = [
            ['value' => $projectCount.'+',  'label' => 'Projects Submitted'],
            ['value' => $mentorCount,         'label' => 'Expert Mentors'],
            ['value' => $investorCount.'+', 'label' => 'Active Investors'],
            ['value' => $developerCount,      'label' => 'Skilled Developers'],
        ];

        return view('home', compact(
            'featuredProjects',
            'mentors',
            'testimonials',
            'stats',
            'specializations',
        ))->with([
            'fullWidth' => true,
            'active' => '',
        ]);
    }

    private function fallbackTestimonials(): array
    {
        return [
            [
                'quote' => 'DevSpace connected us with a mentor who had built and exited a similar startup. That relationship completely changed our trajectory.',
                'name' => 'Amira Mostafa',
                'role' => 'Co-founder, MedTrack Pro',
                'avatar' => 'AM',
                'style' => '',
            ],
            [
                'quote' => 'As an angel investor, the quality of deal flow from DevSpace is remarkable. Every project comes with real technical depth — not just pitch decks.',
                'name' => 'Youssef Badran',
                'role' => 'Angel Investor, Cairo',
                'avatar' => 'YB',
                'style' => 'background:#eef3ff; color:#3B5BDB;',
            ],
            [
                'quote' => 'We went from a class project to a structured mentorship in one intake cycle. The community and investor exposure are genuinely world-class.',
                'name' => 'Salma Sami',
                'role' => 'Founder, SkillMap AR',
                'avatar' => 'SS',
                'style' => 'background:#fff8e1; color:#B45309;',
            ],
        ];
    }
}
