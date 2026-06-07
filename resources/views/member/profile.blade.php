<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }} | LinkedIn Profile</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f3f2ef] text-slate-900 antialiased min-h-screen pb-12 text-left">

    <div class="max-w-[1128px] mx-auto px-4 mt-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            
            <div class="lg:col-span-3 flex flex-col gap-3">
                
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-xs relative">
                    <div class="h-48 bg-[#a0b4b7] w-full bg-gradient-to-r from-slate-400 to-slate-500"></div>
                    
                    <div class="p-6 pt-0 relative flex flex-col items-start">
                        
                        <div class="w-40 h-40 rounded-full overflow-hidden border-4 border-white shadow-xs bg-slate-100 flex items-center justify-center text-slate-400 -mt-24 z-10 mb-4">
                            @if($user->profile_picture)
                                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            @elseif($userRole == 'mentor' && $user->mentor?->profile_picture)
                                <img src="{{ asset('storage/' . $user->mentor->profile_picture) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-20 h-20 text-slate-300" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0 1 12.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 1 1-8 0 4 4 0 0 1 8 0z"/></svg>
                            @endif
                        </div>

                        <div class="w-full flex justify-between items-start flex-wrap gap-4">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h1 class="text-2xl font-bold text-slate-900">{{ $user->name }}</h1>
                                </div>
                                <p class="text-base text-slate-700 mt-1">
                                    @if($userRole == 'developer')
                                        {{ $user->developer->specialization->name ?? 'Full-Stack Developer' }}
                                    @elseif($userRole == 'mentor')
                                        {{ $user->mentor->specialization->name ?? 'Professional Mentor' }} @if($user->mentor->organization) at {{ $user->mentor->organization }} @endif
                                    @endif
                                </p>
                                <p class="text-sm text-slate-500 mt-1">Egypt · <a href="{{ $user->linkedin_url }}" target="_blank" class="text-[#0a66c2] font-semibold hover:underline">Contact info</a></p>
                            </div>

                            <div class="text-sm font-semibold text-slate-800 flex items-center gap-2">
                                <div class="w-8 h-8 bg-slate-100 rounded flex items-center justify-center border border-slate-200">💼</div>
                                <span>{{ $userRole == 'mentor' ? ($user->mentor->organization ?? 'Mentorship & Guidance') : 'Software Development' }}</span>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2 mt-5 w-full">
                            <form action="{{ url('/follow') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="following_id" value="{{ $user->id }}">
                                <button type="submit" class="bg-[#0a66c2] hover:bg-[#004182] text-white text-base font-semibold px-5 py-1.5 rounded-full transition-colors flex items-center gap-1 shadow-xs">
                                    <span class="text-lg">+</span> Follow
                                </button>
                            </form>

                            <a href="{{ url('/messages/create?receiver_id=' . $user->id) }}" class="border border-[#0a66c2] text-[#0a66c2] hover:bg-blue-50 hover:border-2 text-base font-semibold px-5 py-1.5 rounded-full transition-all">
                                Send message
                            </a>
                        </div>

                    </div>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs">
                    <h2 class="text-xl font-bold text-slate-900 mb-3">About</h2>
                    <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-line">
                        {{ $user->bio ?? 'This member has not written a custom bio yet.' }}
                    </p>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs">
                    <h2 class="text-xl font-bold text-slate-900 mb-2">Skills</h2>
                    <p class="text-xs text-slate-500 mb-4">Key skills and technologies they master:</p>
                    
                    @if($skills->count() > 0)
                        <div class="flex flex-col division-y divide-slate-100">
                            @foreach($skills as $skill)
                                <div class="py-3 flex items-center gap-3 first:pt-0 last:pb-0">
                                    <div class="text-slate-400 text-lg">💡</div>
                                    <div>
                                        <h4 class="font-semibold text-sm text-slate-800">{{ $skill->name }}</h4>
                                        <p class="text-xs text-slate-400">Verified and applied in completed projects</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-400 border border-dashed border-slate-200 rounded-lg p-4 text-center">No custom skills have been added to this profile yet.</p>
                    @endif
                </div>

                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs">
                    <h2 class="text-xl font-bold text-slate-900 mb-2">Projects</h2>
                    <p class="text-xs text-slate-500 mb-4">Projects where this member participates in the team.</p>

                    @if($user->teamProjects->count() > 0)
                        <div class="space-y-3">
                            @foreach($user->teamProjects as $project)
                                <a href="{{ route('projects.show', $project) }}" class="block p-4 border border-slate-100 rounded-xl hover:border-slate-200 hover:bg-slate-50 transition">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <h3 class="font-semibold text-sm text-slate-900 truncate">{{ $project->title }}</h3>
                                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $project->description }}</p>
                                        </div>
                                        <span class="text-[11px] bg-slate-100 text-slate-700 rounded-full px-3 py-1">{{ $project->pivot->role ?? 'Team Member' }}</span>
                                    </div>
                                    <div class="mt-3 text-xs text-slate-500">
                                        {{ $project->type ? ucfirst($project->type) : 'Project' }}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-400 border border-dashed border-slate-200 rounded-lg p-4 text-center">This member is not assigned to any team projects yet.</p>
                    @endif
                </div>

            </div>

            <div class="lg:col-span-1 flex flex-col gap-3">
                <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-xs">
                    <h3 class="font-bold text-sm text-slate-900 mb-4">People you may know</h3>
                    
                    <div class="flex items-start gap-3 mb-4 last:mb-0 pb-3 border-b border-slate-100 last:border-0">
                        <div class="w-10 h-10 rounded-full bg-slate-200 shrink-0 overflow-hidden">
                            <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs">👤</div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-xs text-slate-800 truncate">Ahmed Mohamed</h4>
                            <p class="text-[11px] text-slate-500 truncate">UI/UX Designer</p>
                            <button class="mt-2 border border-slate-500 hover:bg-slate-50 text-slate-600 text-xs font-semibold px-3 py-1 rounded-full transition-colors">
                                Connect
                            </button>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 last:mb-0">
                        <div class="w-10 h-10 rounded-full bg-slate-200 shrink-0 overflow-hidden">
                            <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs">👤</div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-xs text-slate-800 truncate">Sara Ahmed</h4>
                            <p class="text-[11px] text-slate-500 truncate">Senior Mentor</p>
                            <button class="mt-2 border border-slate-500 hover:bg-slate-50 text-slate-600 text-xs font-semibold px-3 py-1 rounded-full transition-colors">
                                Connect
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div>

            </div>

        </div>
    </div>

</body>
</html>