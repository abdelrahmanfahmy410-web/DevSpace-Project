@extends('layouts.app')

@section('title', $user->name . ' | Developer Profile')

@push('styles')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            corePlugins: {
                preflight: false,
            },
            theme: {
                extend: {
                    boxShadow: {
                        '2xs': '0 1px 1px 0 rgb(0 0 0 / 0.05)',
                        'xs': '0 1px 2px 0 rgb(0 0 0 / 0.05)',
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
    
    <style>
        /* Mapping your exact design system parameters into Tailwind variables */
    
        :root {
            --font-sans: 'DM Sans', sans-serif;
            --color-brand-green: #1A7A4A;
            --color-brand-green-light: #E8F5EE;
            --color-brand-green-mid: #2d9e63;
            --color-brand-red: #C0392B;
            --color-brand-red-light: #FDECEA;
            --color-brand-bg: #F4F7FA;
            
            /* Overriding default Tailwind surface, text, and border references */
            --color-slate-50: #F4F7FA;
            --color-slate-100: rgba(0,0,0,0.04);
            --color-slate-200: rgba(0,0,0,0.08);
            --color-slate-900: #111827;
            --color-slate-700: #6B7280;
            --color-slate-500: #9CA3AF;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--color-brand-bg);
            transition: all 0.18s ease;
        }

        /* Smooth custom transitions inspired by your styles */
        .interactive-card {
            transition: transform 0.18s ease, border-color 0.18s ease, box-shadow 0.18s ease;
        }
    </style>
    @livewireStyles
@endpush

@section('content')
<div class="text-slate-900 antialiased min-h-screen pb-12 text-left">

    <div class="max-w-[1128px] mx-auto px-4 mt-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            
            <div class="lg:col-span-3 flex flex-col gap-4">
                
                <div class="bg-white rounded-[14px] border border-slate-200 overflow-hidden shadow-xs relative">
                    <div class="h-48 w-full bg-gradient-to-r from-[var(--color-brand-green)] to-[#36c68a] relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 w-40 h-40 rounded-full bg-white opacity-10 blur-2xl"></div>
                        <div class="absolute -left-10 -bottom-10 w-32 h-32 rounded-full bg-white opacity-10 blur-2xl"></div>
                    </div>
                    
                    <div class="p-6 pt-0 relative flex flex-col items-start">
                        
                       <div class="w-40 h-40 rounded-full overflow-hidden border-4 border-white shadow-md bg-slate-50 flex items-center justify-center -mt-20 z-10 mb-4">
                             @if($user->profile_picture)
                                  <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                             @elseif($userRole == 'mentor' && $user->mentor?->profile_picture)
                                  <img src="{{ asset('storage/' . $user->mentor->profile_picture) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                             @else
                                  <div class="w-full h-full bg-[#1A7A4A] text-white flex items-center justify-center text-5xl font-bold">
                                      {{ strtoupper(substr($user->name, 0, 1)) }}
                                  </div>
                             @endif
                        </div>

                        <div class="w-full flex justify-between items-start flex-wrap gap-4">
                            <div>
                                <div class="flex items-center gap-3">
                                    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">{{ $user->name }}</h1>
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold uppercase tracking-wider
                                        @if($userRole == 'developer') bg-[var(--color-brand-green-light)] text-[var(--color-brand-green)]
                                        @elseif($userRole == 'mentor') bg-[#F3E8FF] text-[#6B21A8]
                                        @elseif($userRole == 'investor') bg-amber-50 text-amber-600
                                        @else bg-slate-100 text-slate-600
                                        @endif
                                    ">
                                        {{ ucfirst($userRole) }}
                                    </span>
                                </div>
                                <p class="text-base font-medium text-slate-700 mt-1">
                                    @if($userRole == 'developer')
                                        {{ $user->developer->specialization->name ?? 'Full-Stack Developer' }}
                                    @elseif($userRole == 'mentor')
                                        {{ $user->mentor->specialization->name ?? 'Professional Mentor' }} @if($user->mentor->organization) at {{ $user->mentor->organization }} @endif
                                    @elseif($userRole == 'investor')
                                        Investor
                                    @endif
                                </p>
                                <p class="text-sm text-slate-500 mt-1.5 flex items-center gap-2">
                                    <span class="text-slate-200">•</span> 
                                    <a href="{{ $user->linkedin_url }}" target="_blank" class="text-[var(--color-brand-green)] font-semibold hover:text-[var(--color-brand-green-mid)] hover:underline">Linkedin Profile</a>
                                </p>
                            </div>

                            <div class="text-sm font-medium text-slate-900 flex items-center gap-2 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-[10px]">
                                <div class="w-6 h-6 bg-white rounded-md flex items-center justify-center border border-slate-200 shadow-2xs text-slate-500">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <span>{{ $userRole == 'mentor' ? ($user->mentor->organization ?? 'Mentorship & Guidance') : 'Software Development' }}</span>
                            </div>
                        </div>

            <div class="flex flex-wrap gap-2 mt-5 w-full">
<form action="{{ route('user.follow', $user->id) }}" method="POST">
    @csrf
    <button type="submit">
        {{ auth()->user()->following->contains($user->id) ? 'Unfollow' : 'Follow' }}
    </button>
</form>

                            @auth
                                @if(auth()->id() !== $user->id)
                                    @php
                                        $isFollowing = auth()->user()->following()->where('following_id', $user->id)->exists();
                                    @endphp
                                    <form action="{{ route('user.follow', $user) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="{{ $isFollowing
                                                ? 'border border-[var(--color-brand-green)] text-[var(--color-brand-green)] hover:bg-red-50 hover:border-red-400 hover:text-red-500'
                                                : 'bg-[var(--color-brand-green)] hover:bg-[var(--color-brand-green-mid)] text-white' }}
                                                text-sm font-semibold px-5 py-2 rounded-[10px] transition-colors flex items-center gap-1.5 shadow-sm cursor-pointer">
                                                {{ $isFollowing ? '✓ Following' : '+ Follow' }}
                                        </button>
                                    </form>

                                    <a href="{{ route('conversations.start', $user->id) }}" class="border border-[var(--color-brand-green)] bg-white hover:bg-[var(--color-brand-green)] hover:text-white text-[var(--color-brand-green)] text-sm font-semibold px-5 py-2 rounded-[10px] transition-colors flex items-center gap-1.5 shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                        Message
                                    </a>
                                @endif
                            @endauth

                        </div>

                    </div>
                </div>

                <div class="bg-white rounded-[14px] border border-slate-200 p-6 shadow-xs">
                    <h2 class="text-lg font-bold text-slate-900 mb-3 tracking-tight">About</h2>
                    <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-line">
                        {{ $user->bio ?? 'This member has not written a custom bio yet.' }}
                    </p>
                </div>


                <div class="bg-white rounded-[14px] border border-slate-200 p-6 shadow-xs">
                    <h2 class="text-lg font-bold text-slate-900 mb-1 tracking-tight">Projects</h2>
                    <p class="text-xs text-slate-500 mb-4">Projects where this member participates in the team</p>

                    @if($user->teamProjects->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($user->teamProjects as $project)
                                <a href="{{ route('projects.show', $project) }}" class="interactive-card block p-4 border border-slate-200 rounded-[10px] bg-white hover:border-[var(--color-brand-green-mid)] shadow-[0_2px_8px_rgba(0,0,0,0.07)]">
                                    <div class="flex items-start justify-between gap-3 mb-2">
                                        <div class="min-w-0">
                                            <h3 class="font-semibold text-sm text-slate-900 truncate group-hover:text-[var(--color-brand-green)]">{{ $project->title }}</h3>
                                        </div>
                                        @php
                                            $projRoleStr = strtolower($project->pivot->role ?? '');
                                            $isMentorRole = str_contains($projRoleStr, 'mentor');
                                        @endphp
                                        <span class="text-[11px] font-medium {{ $isMentorRole ? 'bg-[#F3E8FF] text-[#6B21A8]' : 'bg-[var(--color-brand-green-light)] text-[var(--color-brand-green)]' }} rounded-full px-2.5 py-0.5 shrink-0">{{ $project->pivot->role ?? 'Team Member' }}</span>
                                    </div>
                                    <p class="text-xs text-slate-700 line-clamp-2 mb-3 leading-relaxed">{{ $project->description }}</p>
                                    <div class="text-[11px] font-medium text-slate-500 uppercase tracking-wider">
                                        {{ $project->type ? ucfirst($project->type) : 'Project' }}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-500 border border-dashed border-slate-200 rounded-[10px] p-6 text-center bg-slate-50">This member is not assigned to any team projects yet.</p>
                    @endif
                </div>

            </div>

            <div class="lg:col-span-1 flex flex-col gap-4">
                <div class="bg-white rounded-[14px] border border-slate-200 p-6 shadow-xs">
                    <h2 class="text-lg font-bold text-slate-900 mb-1 tracking-tight">Skills</h2>
                    <p class="text-xs text-slate-500 mb-4">Key skills and technologies they master</p>
                    
                    @if($skills->count() > 0)
                        <div class="flex flex-col divide-y divide-slate-200">
                            @foreach($skills as $skill)
                                <div class="py-3.5 flex items-center gap-3.5 first:pt-0 last:pb-0">
                                    <div class="w-8 h-8 rounded-[6px] bg-[var(--color-brand-green-light)] text-[var(--color-brand-green)] flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-sm text-slate-900">{{ $skill->name }}</h4>
                                        <p class="text-xs text-slate-500 mt-0.5">Verified and applied in completed projects</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-500 border border-dashed border-slate-200 rounded-[10px] p-6 text-center bg-slate-50">No custom skills have been added to this profile yet.</p>
                    @endif
                </div>

                <div class="bg-white rounded-[14px] border border-slate-200 p-4 shadow-xs">
                    <h3 class="font-bold text-sm text-slate-900 mb-4 tracking-tight">People you may know</h3>

                    @if($suggestions->isEmpty())
                        <p class="text-xs text-slate-500 text-center py-4">No suggestions available.</p>
                    @else
                    <div class="flex flex-col gap-4">
                        @foreach($suggestions as $suggestion)
                            @php
                            $suggRole = $suggestion->developer ? 'developer' : ($suggestion->mentor ? 'mentor' : 'investor');
                    $suggTitle = match($suggRole) {
                        'developer' => $suggestion->developer->specialization->name ?? 'Developer',
                        'mentor'    => $suggestion->mentor->specialization->name ?? 'Mentor',
                        default     => 'Investor',
                    };
                    $roleLabel = match($suggRole) {
                        'developer' => ['label' => 'Developer', 'bg' => 'bg-[var(--color-brand-green-light)]', 'text' => 'text-[var(--color-brand-green)]'],
                        'mentor'    => ['label' => 'Mentor',    'bg' => 'bg-[#F3E8FF]', 'text' => 'text-[#6B21A8]'],
                        default     => ['label' => 'Investor',  'bg' => 'bg-amber-50',  'text' => 'text-amber-600'],
                    };
                    @endphp

                    <div class="flex items-start gap-3 pb-4 border-b border-slate-200 last:border-0 last:pb-0">

                        <a href="{{ route('member.other_profile', $suggestion->id) }}" class="shrink-0">
                            <div class="w-10 h-10 rounded-full bg-slate-50 border border-slate-200 overflow-hidden flex items-center justify-center shadow-2xs">
                                @if($suggestion->profile_picture)
                                    <img src="{{ asset('storage/' . $suggestion->profile_picture) }}"
                                         alt="{{ $suggestion->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-[#1A7A4A] text-white flex items-center justify-center text-sm font-bold">
                                        {{ strtoupper(substr($suggestion->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                        </a>

                        <div class="flex-1 min-w-0">
                            <a href="{{ route('member.other_profile', $suggestion->id) }}">
                                <h4 class="font-semibold text-xs text-slate-900 truncate hover:text-[var(--color-brand-green)]">
                                    {{ $suggestion->name }}
                                </h4>
                            </a>
                            <p class="text-[11px] text-slate-700 truncate mt-0.5">{{ $suggTitle }}</p>
                            <span class="inline-block mt-1 text-[10px] font-semibold px-2 py-0.5 rounded-full {{ $roleLabel['bg'] }} {{ $roleLabel['text'] }}">
                            {{ $roleLabel['label'] }}
                            </span>

                            @auth
                            @if(auth()->id() !== $suggestion->id)
                            @php
                                $isFollowingSuggestion = auth()->user()->following()->where('following_id', $suggestion->id)->exists();
                            @endphp
                            <form action="{{ route('user.follow', $suggestion) }}" method="POST">
                                @csrf
                                <button type="submit"
                                class="mt-2.5 w-full border {{ $isFollowingSuggestion ? 'border-[var(--color-brand-green)] text-[var(--color-brand-green)] hover:bg-red-50 hover:border-red-400 hover:text-red-500' : 'border-slate-200 hover:border-[var(--color-brand-green)] hover:bg-[var(--color-brand-green-light)] hover:text-[var(--color-brand-green)] text-slate-900' }} text-xs font-semibold py-1.5 rounded-[6px] transition-colors cursor-pointer">
                                {{ $isFollowingSuggestion ? '✓ Following' : 'Follow' }}
                                </button>
                            </form>
                            @endif
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

        </div>
    </div>

    @push('scripts')
        @livewireScripts
    @endpush
</div>
@endsection
