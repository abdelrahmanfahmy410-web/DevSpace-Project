<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $project->title ?? 'Project' }} — DevSpace</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;1,9..40,400&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/add_project.css') }}" />
  <style>
    .project-meta { display:flex; gap:12px; align-items:center; margin-top:8px; }
    .project-meta a { color:var(--color-primary); font-weight:600; }
    .project-card { background:var(--color-white); border:1px solid var(--color-border); border-radius:12px; padding:20px; }
  </style>
</head>
<body>

  <header class="topbar">
    <div class="topbar-logo">
      <div class="topbar-logo-mark">DS</div>
      Dev<span>Space</span>
    </div>
  </header>

  <div class="shell">
    <main class="main">
      <div class="inner">
        <div class="page-eyebrow"><span class="eyebrow-dot"></span> Projects</div>
        <h1 class="page-title">{{ $project->title }}</h1>
        <p class="page-subtitle">{{ \Illuminate\Support\Str::limit($project->description, 160) }}</p>

        <div style="margin-top:18px; display:flex; gap:12px;">
          <a href="{{ url()->previous() }}" class="btn" style="padding:8px 12px;border-radius:8px;background:var(--color-bg-light);border:1px solid var(--color-border);">← Back</a>
          @if($project->repository_link)
            <a href="{{ $project->repository_link }}" target="_blank" class="btn" style="padding:8px 12px;border-radius:8px;background:var(--color-white);border:1px solid var(--color-border);">Repository</a>
          @endif
          @if($project->live_demo_link)
            <a href="{{ $project->live_demo_link }}" target="_blank" class="btn" style="padding:8px 12px;border-radius:8px;background:var(--color-primary);color:#fff;">Live Demo</a>
          @endif
        </div>

        <div class="card" style="margin-top:18px;">
          <div class="card-body project-card">
            <h3 class="card-title">Description</h3>
            <div style="margin-top:8px; color:var(--color-body-text); line-height:1.7;">{!! nl2br(e($project->description)) !!}</div>

            <div style="margin-top:18px;">
              <h4 class="card-sub">Type</h4>
              <div class="project-meta">{{ $project->type }}</div>
            </div>

            @if($project->skills && $project->skills->count())
            <div style="margin-top:18px;">
              <h4 class="card-sub">Skills</h4>
              <div style="margin-top:8px; display:flex; gap:8px; flex-wrap:wrap;">
                @foreach($project->skills as $skill)
                  <span style="background:var(--color-bg-light);padding:6px 10px;border-radius:999px;font-size:13px;color:var(--color-muted);">{{ $skill->name }}</span>
                @endforeach
              </div>
            </div>
            @endif

            @if($project->specializations && $project->specializations->count())
            <div style="margin-top:18px;">
              <h4 class="card-sub">Specializations</h4>
              <div style="margin-top:8px; display:flex; gap:8px; flex-wrap:wrap;">
                @foreach($project->specializations as $s)
                  <span style="background:var(--color-primary-bg);padding:6px 10px;border-radius:999px;font-size:13px;color:var(--color-primary);">{{ $s->name }}</span>
                @endforeach
              </div>
            </div>
            @endif

            @if($project->team_roles && $project->team_roles->count())
            <div style="margin-top:18px;">
              <h4 class="card-sub">Team</h4>
              <div style="margin-top:8px; display:flex; gap:12px; flex-wrap:wrap;">
                @foreach($project->team_roles as $tr)
                  <div style="display:flex;align-items:center;gap:8px;padding:6px 8px;border-radius:8px;border:1px solid var(--color-border);background:var(--color-white);">
                    <div style="width:36px;height:36px;border-radius:50%;background:var(--color-primary-bg);display:grid;place-items:center;color:var(--color-primary);font-weight:700;">{{ strtoupper(substr($tr->name,0,2)) }}</div>
                    <div>
                      <div style="font-weight:700;font-size:14px;">{{ $tr->name }}</div>
                      <div style="font-size:12px;color:var(--color-muted);">{{ $tr->email }}</div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
            @endif

          </div>
        </div>

      </div>
    </main>
  </div>

</body>
</html>
