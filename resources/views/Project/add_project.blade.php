@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Add Project — DevSpace</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;1,9..40,400&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/add_project.css') }}" />
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<style>
/* ── Override Default Container for Wide WordPress Layout ── */
.inner {
  max-width: 1200px !important;
  margin: 0 auto;
}

/* ── WordPress-style 2/3 + 1/3 layout ── */
.wp-layout {
  display: flex;
  gap: 20px;
  align-items: flex-start;
}

.wp-main {
  flex: 1;
  min-width: 0;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.wp-sidebar {
  flex: 0 0 320px; /* Fixed width for sidebar like WordPress */
  position: sticky;
  top: 84px; /* Account for topbar (60px) + some spacing */
  display: flex;
  flex-direction: column;
  gap: 20px;
}

/* ── Meta Box (Card) Styling like WordPress ── */
.wp-main .card,
.wp-sidebar .card,
.wp-sidebar .publish-box,
.wp-sidebar .preview-panel {
  margin-bottom: 0;
  background: #fff;
  border: 1px solid #c3c4c7; /* WP-like clean border */
  border-radius: 4px; /* WP uses slightly sharper corners */
  box-shadow: 0 1px 1px rgba(0,0,0,0.04); /* Subtle WP shadow */
  overflow: hidden;
}

/* Hide bulky elements to make it cleaner */
.wp-layout .card-icon {
  display: none;
}
.wp-layout .card-header-left {
  gap: 0;
}

/* Card Headers */
.wp-main .card-header,
.wp-sidebar .card-header,
.wp-sidebar .publish-box-header {
  padding: 14px 16px;
  border-bottom: 1px solid #c3c4c7;
  background: #fff;
}

/* Title text */
.wp-main .card-title,
.wp-sidebar .card-title,
.wp-sidebar .publish-box-header {
  font-size: 14px;
  font-weight: 600;
  color: #1d2327;
  display: flex;
  align-items: center;
  gap: 8px;
}

.wp-main .card-sub,
.wp-sidebar .card-sub {
  font-size: 12px;
  color: #50575e;
  margin-top: 4px;
  font-weight: normal;
}

/* Card Body */
.wp-main .card-body,
.wp-sidebar .card-body,
.wp-sidebar .publish-box-body {
  padding: 16px 20px;
  display: flex;
  flex-direction: column;
  gap: 16px;
}

/* ── Inputs & Form Groups ── */
.wp-layout .form-group {
  margin-bottom: 0; /* Let flex gap handle spacing */
}

.wp-layout .form-label {
  font-size: 13px;
  font-weight: 600;
  color: #1d2327;
  margin-bottom: 6px;
}

.wp-layout .form-hint {
  font-size: 12px;
  color: #646970;
  margin-top: 6px;
  line-height: 1.4;
}

.wp-layout .form-input,
.wp-layout .form-textarea {
  padding: 10px 14px;
  font-size: 14px;
  color: #2c3338;
  border: 1px solid #8c8f94; /* WP-like input border */
  border-radius: 4px;
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);
  transition: border-color .05s ease-in-out, box-shadow .05s ease-in-out;
}

.wp-layout .form-input:focus,
.wp-layout .form-textarea:focus {
  border-color: var(--color-primary);
  box-shadow: 0 0 0 1px var(--color-primary);
  outline: none;
}

/* Make main Title input larger like WordPress */
.wp-main #title {
  font-size: 20px;
  font-weight: 500;
  padding: 12px 16px;
  line-height: 1.4;
}

/* ── Specific Publish Box Styles ── */
.publish-box-header svg {
  width: 16px;
  height: 16px;
  fill: #1d2327;
  flex-shrink: 0;
}

.publish-meta-row {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  color: #50575e;
}

.publish-meta-row svg {
  width: 15px;
  height: 15px;
  fill: #50575e;
  flex-shrink: 0;
}

.publish-box-footer {
  padding: 14px 16px;
  background: #f6f7f7; /* WP Light Gray Footer */
  border-top: 1px solid #c3c4c7;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 10px;
}

.publish-box-footer .btn-primary {
  flex: 1;
  justify-content: center;
  padding: 10px 16px;
  font-size: 14px;
  border-radius: 4px;
}

/* Live Preview in Sidebar */
.wp-sidebar .preview-panel {
  padding: 16px;
  background: #1d2327; /* Dark like a WP preview box */
  color: #fff;
}
.wp-sidebar .preview-label {
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
  margin-bottom: 12px;
  color: rgba(255,255,255,0.6);
  border-bottom: 1px solid rgba(255,255,255,0.1);
  padding-bottom: 8px;
}

.wp-sidebar .preview-card {
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 6px;
  padding: 16px;
}

/* Responsive */
@media (max-width: 992px) {
  .wp-layout {
    flex-direction: column;
  }
  .wp-main, .wp-sidebar {
    width: 100%;
    flex: none;
  }
  .wp-sidebar {
    position: static;
  }
}
</style>
</head>
<body>

<div class="shell">
  <main class="main">
    <div class="inner">

      <!-- PAGE HEADER -->
      <div class="page-eyebrow"><span class="eyebrow-dot"></span> Graduate Projects</div>
      <h1 class="page-title">Add New Project</h1>
      <p class="page-subtitle">Fill in your project details so investors and mentors can discover and connect with your team.</p>

      <form method="POST" action="/project/create/" id="projectForm" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="wp-layout">

          <!-- ══════════════════════════════════════════
               2/3  —  MAIN COLUMN (Required inputs)
          ══════════════════════════════════════════ -->
          <div class="wp-main">

            <!-- ── CARD 1: Project Details ── -->
            <div class="card">
              <div class="card-header">
                <div class="card-header-left">
                  <div class="card-icon">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/></svg>
                  </div>
                  <div>
                    <div class="card-title">Project Details</div>
                    <div class="card-sub">Title and description of your project</div>
                  </div>
                </div>
              </div>
              <div class="card-body">

                <!-- title -->
                <div class="form-group">
                  <label class="form-label" for="title">
                    Project Title <span class="req">*</span>
                  </label>
                  <input
                    type="text"
                    id="title"
                    name="title"
                    class="form-input"
                    placeholder="e.g. AgriSense Egypt"
                    required
                    maxlength="100"
                    autocomplete="off"
                    oninput="onTitleInput(this)"
                  />
                  <div class="char-count"><span id="titleCount">0</span> / 100</div>
                  <div class="field-error" id="titleError">
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    Project title is required.
                  </div>
                </div>

                <!-- description -->
                <div class="form-group">
                  <label class="form-label" for="description">
                    Description <span class="req">*</span>
                  </label>
                  <textarea
                    id="description"
                    name="description"
                    class="form-textarea"
                    placeholder="Describe your project — the problem it solves, your approach, current progress, and what makes it unique…"
                    required
                    maxlength="2000"
                    oninput="onDescInput(this)"
                  ></textarea>
                  <div class="char-count"><span id="descCount">0</span> / 2000</div>
                  <div class="field-error" id="descError">
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    Description is required.
                  </div>
                </div>

              </div>
            </div>

            <!-- ── CARD 2: Project Type ── -->
            <div class="card">
              <div class="card-header">
                <div class="card-header-left">
                  <div class="card-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                  </div>
                  <div>
                    <div class="card-title">Project Type</div>
                    <div class="card-sub">Enter the category that best fits your project</div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="form-group" style="margin-bottom:0;">
                  <label class="form-label" for="type_input">
                    Type <span class="req">*</span>
                  </label>
                  <input
                    type="text"
                    id="type_input"
                    name="type"
                    class="form-input"
                    placeholder="e.g. Web Development, AI/ML, IoT…"
                    maxlength="100"
                    oninput="updatePreview(); document.getElementById('typeError').classList.remove('show'); this.classList.remove('error');"
                  />
                  <div class="field-error" id="typeError" style="margin-top:8px;">
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    Please enter a project type.
                  </div>
                </div>
              </div>
            </div>

            <!-- ── CARD 5: Specializations & Skills ── -->
            <div class="card">
              <div class="card-header">
                <div class="card-header-left">
                  <div class="card-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                  </div>
                  <div>
                    <div class="card-title">Specializations & Skills</div>
                    <div class="card-sub">Select your project's specializations and related skills</div>
                  </div>
                </div>
              </div>
              <div class="card-body">

                <div class="form-group">
                  <label class="form-label" for="specializations">
                    Specializations <span class="req">*</span>
                  </label>
                  <select id="specializations" name="specializations[]" class="form-input" multiple style="height: auto; min-height: 100px;">
                    @foreach($specializations as $specialization)
                      <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group" style="margin-bottom:0;">
                  <label class="form-label">Skills</label>
                  <div id="skills-checkbox-container" class="skills-checkbox-grid">
                    <p class="form-hint">Please select a specialization to view available skills...</p>
                  </div>
                </div>

              </div>
            </div>

            <!-- ── CARD 6: Team Members ── -->
            <div class="card">
              <div class="card-header">
                <div class="card-header-left">
                  <div class="card-icon">
                    <svg viewBox="0 0 24 24">
                      <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                    </svg>
                  </div>
                  <div>
                    <div class="card-title">Team Members</div>
                    <div class="card-sub">Add people working on this project</div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label class="form-label">Team Members</label>
                  <div id="team-members-container" class="team-members-list">
                    <p class="form-hint">No team members added yet. Click the button below to add one.</p>
                  </div>
                  <button type="button" class="btn btn-secondary" onclick="addTeamMemberField()" style="margin-top:12px;">
                    <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:currentColor;margin-right:6px;">
                      <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                    </svg>
                    Add Team Member
                  </button>
                </div>
              </div>
            </div>

          </div><!-- /.wp-main -->


          <!-- ══════════════════════════════════════════
               1/3  —  SIDEBAR (Optional inputs + Publish)
          ══════════════════════════════════════════ -->
          <div class="wp-sidebar">

            <!-- ── CARD 3: Project Images ── -->
            <div class="card">
              <div class="card-header">
                <div class="card-header-left">
                  <div class="card-icon">
                    <svg viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                  </div>
                  <div>
                    <div class="card-title">Project Images</div>
                    <div class="card-sub">Upload cover images</div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="form-group" style="margin-bottom:0;">
                  <label class="form-label" for="project_image">
                    Cover Images <span class="opt">(optional)</span>
                  </label>
                  <input
                    type="file"
                    id="project_image"
                    name="project_images[]"
                    multiple
                    class="form-input"
                    accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml"
                    onchange="previewImage(this)"
                    style="padding: 8px 12px; cursor: pointer;"
                  />
                  <p class="form-hint">JPG, PNG, GIF, SVG — max 2MB</p>
                  <div id="imagePreviewWrapper" style="display:none; margin-top:12px;"></div>
                </div>
              </div>
            </div>

            <!-- ── CARD 3B: Project Videos ── -->
            <div class="card">
              <div class="card-header">
                <div class="card-header-left">
                  <div class="card-icon">
                    <svg viewBox="0 0 24 24"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>
                  </div>
                  <div>
                    <div class="card-title">Project Videos</div>
                    <div class="card-sub">Upload demo or pitch videos</div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="form-group" style="margin-bottom:0;">
                  <label class="form-label" for="project_video">
                    Project Videos <span class="opt">(optional)</span>
                  </label>
                  <input
                    type="file"
                    id="project_video"
                    name="project_videos[]"
                    multiple
                    class="form-input"
                    accept="video/*"
                    onchange="previewVideo(this)"
                    style="padding: 8px 12px; cursor: pointer;"
                  />
                  <p class="form-hint">MP4, WebM, Ogg — max 50MB</p>
                  <div id="videoPreviewWrapper" style="display:none; margin-top:12px;"></div>
                </div>
              </div>
            </div>

            <!-- ── CARD 4: Links ── -->
            <div class="card">
              <div class="card-header">
                <div class="card-header-left">
                  <div class="card-icon">
                    <svg viewBox="0 0 24 24"><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/></svg>
                  </div>
                  <div>
                    <div class="card-title">Project Links</div>
                    <div class="card-sub">Help people explore your work</div>
                  </div>
                </div>
              </div>
              <div class="card-body">

                <!-- repository_link -->
                <div class="form-group">
                  <label class="form-label" for="repository_link">
                    Repository Link <span class="opt">(optional)</span>
                  </label>
                  <div class="input-icon-wrap">
                    <svg viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
                    <input
                      type="url"
                      id="repository_link"
                      name="repository_link"
                      class="form-input"
                      placeholder="https://github.com/your-username/your-repo"
                      oninput="updatePreview()"
                      onblur="validateUrl(this,'repoError')"
                    />
                  </div>
                  <div class="field-error" id="repoError">
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    Please enter a valid URL starting with https://
                  </div>
                </div>

                <!-- live_demo_link -->
                <div class="form-group" style="margin-bottom:0;">
                  <label class="form-label" for="live_demo_link">
                    Live Demo Link <span class="opt">(optional)</span>
                  </label>
                  <div class="input-icon-wrap">
                    <svg viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm6.93 6h-2.95a15.65 15.65 0 00-1.38-3.56A8.03 8.03 0 0118.92 8zM12 4.04c.83 1.2 1.48 2.53 1.91 3.96h-3.82c.43-1.43 1.08-2.76 1.91-3.96zM4.26 14C4.1 13.36 4 12.69 4 12s.1-1.36.26-2h3.38c-.08.66-.14 1.32-.14 2s.06 1.34.14 2H4.26zm.82 2h2.95c.32 1.25.78 2.45 1.38 3.56A7.987 7.987 0 015.08 16zm2.95-8H5.08a7.987 7.987 0 014.33-3.56A15.65 15.65 0 008.03 8zM12 19.96c-.83-1.2-1.48-2.53-1.91-3.96h3.82c-.43 1.43-1.08 2.76-1.91 3.96zM14.34 14H9.66c-.09-.66-.16-1.32-.16-2s.07-1.35.16-2h4.68c.09.65.16 1.32.16 2s-.07 1.34-.16 2zm.25 5.56c.6-1.11 1.06-2.31 1.38-3.56h2.95a8.03 8.03 0 01-4.33 3.56zM16.36 14c.08-.66.14-1.32.14-2s-.06-1.34-.14-2h3.38c.16.64.26 1.31.26 2s-.1 1.36-.26 2h-3.38z"/></svg>
                    <input
                      type="url"
                      id="live_demo_link"
                      name="live_demo_link"
                      class="form-input"
                      placeholder="https://your-live-demo.com"
                      oninput="updatePreview()"
                      onblur="validateUrl(this,'demoError')"
                    />
                  </div>
                  <div class="field-error" id="demoError">
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    Please enter a valid URL starting with https://
                  </div>
                  <p class="form-hint">Vercel, Railway, Heroku, or any hosted URL.</p>
                </div>

              </div>
            </div>

            <!-- ── LIVE PREVIEW ── -->
            <div class="preview-panel" style="margin-top:0;">
              <div class="preview-label">Live preview — how your project will appear</div>
              <div class="preview-card">
                <div class="preview-top">
                  <div class="preview-av" id="previewAv">DS</div>
                  <div>
                    <div class="preview-name" id="previewName">Your Project Title</div>
                    <div class="preview-type" id="previewType">Select a type below</div>
                  </div>
                </div>
                <div class="preview-desc" id="previewDesc">Your description will appear here…</div>
                <div class="preview-links" id="previewLinks"></div>
              </div>
            </div>

            <!-- ── PUBLISH BOX ── -->
            <div class="publish-box">
              <div class="publish-box-header">
                <svg viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
                Publish
              </div>
              <div class="publish-box-body">
                <div class="publish-meta-row">
                  <svg viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                  Data saved securely
                </div>
                <div class="publish-meta-row">
                  <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                  Visible to investors & mentors
                </div>
              </div>
              <div class="publish-box-footer">
                <button type="button" class="btn btn-ghost" onclick="window.history.back()">Cancel</button>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                  Publish Project
                  <svg viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
                </button>
              </div>
            </div>

          </div><!-- /.wp-sidebar -->

        </div><!-- /.wp-layout -->

      </form>
    </div>
  </main>
</div>

<script>

  // ─────────────────────────────────────────────────────────────────────────
  // SPECIALIZATIONS — Tom Select
  // ─────────────────────────────────────────────────────────────────────────
  var tomSelectControl = new TomSelect("#specializations", {
    plugins: ['remove_button'],
    create: false,
    placeholder: "Choose your majors...",
  });

  tomSelectControl.on('change', function(values) {
    const selectedOptions = tomSelectControl.getValue();
    const skillsContainer = document.getElementById('skills-checkbox-container');

    if (!selectedOptions || selectedOptions.length === 0) {
      skillsContainer.innerHTML = '<p class="form-hint">Please select a specialization to view available skills...</p>';
      return;
    }

    skillsContainer.innerHTML = '<p class="form-hint" style="color:#6b7280;">Loading skills…</p>';

    const fetchPromises = selectedOptions.map(specId => {
      let url = "{{ route('projects.get_skills', ':id') }}".replace(':id', specId);
      return fetch(url).then(response => {
        if (!response.ok) throw new Error('Network error');
        return response.json();
      });
    });

    Promise.all(fetchPromises)
      .then(results => {
        skillsContainer.innerHTML = '';
        let allSkills = [];
        let uniqueSkillIds = new Set();

        results.forEach(skillsArray => {
          skillsArray.forEach(skill => {
            if (!uniqueSkillIds.has(skill.id)) {
              uniqueSkillIds.add(skill.id);
              allSkills.push(skill);
            }
          });
        });

        if (allSkills.length > 0) {
          allSkills.forEach(skill => {
            const label = document.createElement('label');
            label.className = 'skill-checkbox-item';
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.name = 'skills[]';
            checkbox.value = skill.id;
            label.appendChild(checkbox);
            label.appendChild(document.createTextNode(' ' + skill.name));
            skillsContainer.appendChild(label);
          });
        } else {
          skillsContainer.innerHTML = '<p class="form-hint" style="color:#ef4444;">No skills registered for these specializations.</p>';
        }
      })
      .catch(error => {
        console.error('Error fetching skills:', error);
        skillsContainer.innerHTML = '<p class="form-hint" style="color:#ef4444;">Error loading skills. Please try again.</p>';
      });
  });

  // ─────────────────────────────────────────────────────────────────────────
  // PROJECT IMAGES
  // ─────────────────────────────────────────────────────────────────────────
  function previewImage(input) {
    const wrapper = document.getElementById('imagePreviewWrapper');
    wrapper.innerHTML = '';

    if (input.files && input.files.length > 0) {
      wrapper.style.display = 'block';

      Array.from(input.files).forEach((file) => {
        const reader = new FileReader();
        reader.onload = function(e) {
          const container = document.createElement('div');
          container.style.cssText = 'display:inline-block; margin:4px; position:relative;';
          container.innerHTML = `
            <img src="${e.target.result}"
                 style="width:100px; height:80px; object-fit:cover; border-radius:8px; border:1px solid var(--border);" />
            <span style="display:block; font-size:11px; color:var(--color-muted); text-align:center; margin-top:2px; max-width:100px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
              ${file.name}
            </span>
          `;
          wrapper.appendChild(container);
        };
        reader.readAsDataURL(file);
      });

      const removeBtn = document.createElement('button');
      removeBtn.type = 'button';
      removeBtn.onclick = clearImage;
      removeBtn.style.cssText = 'display:block; margin-top:8px; font-size:12.5px; color:var(--red); background:none; border:none; cursor:pointer; padding:0;';
      removeBtn.textContent = '✕ Remove all images';
      wrapper.appendChild(removeBtn);
    }
  }

  function clearImage() {
    document.getElementById('project_image').value = '';
    const wrapper = document.getElementById('imagePreviewWrapper');
    wrapper.style.display = 'none';
    wrapper.innerHTML = '';
  }

  // ─────────────────────────────────────────────────────────────────────────
  // PROJECT VIDEOS
  // ─────────────────────────────────────────────────────────────────────────
  function previewVideo(input) {
    const wrapper = document.getElementById('videoPreviewWrapper');
    wrapper.innerHTML = '';

    if (input.files && input.files.length > 0) {
      wrapper.style.display = 'block';

      Array.from(input.files).forEach((file) => {
        const videoUrl = URL.createObjectURL(file);
        const container = document.createElement('div');
        container.style.cssText = 'display:inline-block; margin:4px; position:relative; vertical-align:top;';
        container.innerHTML = `
          <video src="${videoUrl}"
                 style="width:140px; height:80px; object-fit:cover; border-radius:8px; border:1px solid var(--border);" controls></video>
          <span style="display:block; font-size:11px; color:var(--color-muted); text-align:center; margin-top:2px; max-width:140px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
            ${file.name}
          </span>
        `;
        wrapper.appendChild(container);
      });

      const removeBtn = document.createElement('button');
      removeBtn.type = 'button';
      removeBtn.onclick = clearVideo;
      removeBtn.style.cssText = 'display:block; margin-top:8px; font-size:12.5px; color:var(--red); background:none; border:none; cursor:pointer; padding:0;';
      removeBtn.textContent = '✕ Remove all videos';
      wrapper.appendChild(removeBtn);
    }
  }

  function clearVideo() {
    document.getElementById('project_video').value = '';
    const wrapper = document.getElementById('videoPreviewWrapper');
    wrapper.style.display = 'none';
    wrapper.innerHTML = '';
  }

  // ─────────────────────────────────────────────────────────────────────────
  // FORM INTERACTIONS
  // ─────────────────────────────────────────────────────────────────────────
  function onTitleInput(el) {
    document.getElementById('titleCount').textContent = el.value.length;
    document.getElementById('titleCount').parentElement.classList.toggle('over', el.value.length > 95);
    updatePreview();
  }

  function onDescInput(el) {
    document.getElementById('descCount').textContent = el.value.length;
    document.getElementById('descCount').parentElement.classList.toggle('over', el.value.length > 1900);
    updatePreview();
  }

  function validateUrl(input, errorId) {
    const err = document.getElementById(errorId);
    if (input.value && !input.value.startsWith('https://')) {
      input.classList.add('error');
      err.classList.add('show');
    } else {
      input.classList.remove('error');
      err.classList.remove('show');
    }
    updatePreview();
  }

  function updatePreview() {
    const title = document.getElementById('title').value.trim();
    const desc  = document.getElementById('description').value.trim();
    const type  = document.getElementById('type_input').value;
    const repo  = document.getElementById('repository_link').value.trim();
    const demo  = document.getElementById('live_demo_link').value.trim();

    const words = title.split(/\s+/).filter(Boolean);
    document.getElementById('previewAv').textContent =
      words.length >= 2
        ? words[0][0].toUpperCase() + words[1][0].toUpperCase()
        : title.slice(0, 2).toUpperCase() || 'DS';

    document.getElementById('previewName').textContent = title || 'Your Project Title';
    document.getElementById('previewType').textContent = type  || 'Select a type above';
    document.getElementById('previewDesc').textContent =
      desc ? (desc.length > 120 ? desc.slice(0, 120) + '…' : desc) : 'Your description will appear here…';

    const linksEl = document.getElementById('previewLinks');
    linksEl.innerHTML = '';
    if (repo) {
      linksEl.innerHTML += `<span class="preview-link"><svg viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg> Repository</span>`;
    }
    if (demo) {
      linksEl.innerHTML += `<span class="preview-link"><svg viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm6.93 6h-2.95a15.65 15.65 0 00-1.38-3.56A8.03 8.03 0 0118.92 8z"/></svg> Live Demo</span>`;
    }
  }

  // ─────────────────────────────────────────────────────────────────────────
  // FORM VALIDATION & SUBMIT
  // ─────────────────────────────────────────────────────────────────────────
  document.getElementById('projectForm').addEventListener('submit', function(e) {
    let valid = true;

    const title = document.getElementById('title');
    const titleErr = document.getElementById('titleError');
    if (!title.value.trim()) {
      title.classList.add('error');
      titleErr.classList.add('show');
      valid = false;
    } else {
      title.classList.remove('error');
      titleErr.classList.remove('show');
    }

    const desc = document.getElementById('description');
    const descErr = document.getElementById('descError');
    if (!desc.value.trim()) {
      desc.classList.add('error');
      descErr.classList.add('show');
      valid = false;
    } else {
      desc.classList.remove('error');
      descErr.classList.remove('show');
    }

    const typeVal = document.getElementById('type_input').value.trim();
    const typeErr = document.getElementById('typeError');
    if (!typeVal) {
      document.getElementById('type_input').classList.add('error');
      typeErr.classList.add('show');
      valid = false;
    } else {
      document.getElementById('type_input').classList.remove('error');
      typeErr.classList.remove('show');
    }

    if (!valid) { e.preventDefault(); return; }

    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = `<svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor" style="animation:spin 0.8s linear infinite"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/></svg> Publishing…`;
  });

  document.getElementById('title').addEventListener('input', function() {
    this.classList.remove('error');
    document.getElementById('titleError').classList.remove('show');
  });

  document.getElementById('description').addEventListener('input', function() {
    this.classList.remove('error');
    document.getElementById('descError').classList.remove('show');
  });

  // ─────────────────────────────────────────────────────────────────────────
  // TEAM MEMBERS
  // ─────────────────────────────────────────────────────────────────────────
  let teamMemberCount = 0;

  window.addTeamMemberField = function () {
    const container = document.getElementById("team-members-container");
    const placeholder = container.querySelector(".form-hint");
    if (placeholder) placeholder.remove();

    teamMemberCount++;
    const id = "team-member-" + teamMemberCount;
    const selectId = id + "-user-select";

    const item = document.createElement("div");
    item.className = "team-member-item";
    item.id = id;
    item.innerHTML = `
      <div>
        <label class="form-label" for="${selectId}">Team Member</label>
        <select id="${selectId}" name="team_members[${teamMemberCount}][user_id]" class="form-input"></select>
      </div>
      <div>
        <label class="form-label" for="${id}-role">Role</label>
        <input type="text" id="${id}-role" name="team_members[${teamMemberCount}][role]"
               class="form-input" placeholder="e.g. Frontend Developer" />
      </div>
      <button type="button" class="team-member-remove"
              onclick="removeTeamMember('${id}')" aria-label="Remove">✕</button>
    `;

    container.appendChild(item);

    new TomSelect("#" + selectId, {
      valueField: "value",
      labelField: "text",
      searchField: "text",
      placeholder: "Search and select a user…",
      load: function (query, callback) {
        if (!query.length) return callback();
        fetch(`/api/users/search?q=${encodeURIComponent(query)}`)
          .then((res) => res.json())
          .then((data) => callback(data))
          .catch(() => callback());
      },
    });
  };

  window.removeTeamMember = function (id) {
    const item = document.getElementById(id);
    if (item) item.remove();

    const container = document.getElementById("team-members-container");
    if (container.children.length === 0) {
      container.innerHTML = '<p class="form-hint">No team members added yet. Click the button below to add one.</p>';
    }
  };

</script>
</body>
</html>

@endsection