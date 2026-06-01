@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/project_add.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <main class="main">
        <div class="inner">

            <!-- PAGE HEADER -->
            <div class="page-eyebrow"><span class="eyebrow-dot"></span> Graduate Projects</div>
            <h1 class="page-title">Add New Project</h1>
            <p class="page-subtitle">Fill in your project details so investors and mentors can discover and connect with your
                team.</p>

            <form method="POST" action="{{ route('projects.store') }}" id="projectForm" novalidate>
                @csrf

                <!-- ── CARD 1: Project Details ── -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon">
                                <svg viewBox="0 0 24 24">
                                    <path
                                        d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z" />
                                </svg>
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
                            <input type="text" id="title" name="title" class="form-input"
                                placeholder="e.g. AgriSense Egypt" required maxlength="100" autocomplete="off"
                                oninput="onTitleInput(this)" />
                            <div class="char-count"><span id="titleCount">0</span> / 100</div>
                            <div class="field-error" id="titleError">
                                <svg viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                                </svg>
                                Project title is required.
                            </div>
                        </div>

                        <!-- description -->
                        <div class="form-group">
                            <label class="form-label" for="description">
                                Description <span class="req">*</span>
                            </label>
                            <textarea id="description" name="description" class="form-textarea"
                                placeholder="Describe your project — the problem it solves, your approach, current progress, and what makes it unique…"
                                required maxlength="2000" oninput="onDescInput(this)"></textarea>
                            <div class="char-count"><span id="descCount">0</span> / 2000</div>
                            <div class="field-error" id="descError">
                                <svg viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                                </svg>
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
                                <svg viewBox="0 0 24 24">
                                    <path
                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                            </div>
                            <div>
                                <div class="card-title">Project Type</div>
                                <div class="card-sub">Choose the category that best fits your project</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label" for="type_input">Type <span class="req">*</span></label>
                            <input type="text" id="type_input" name="type" class="form-input"
                                placeholder="e.g. Agriculture, Fintech, Education…" required autocomplete="off" oninput="updatePreview()" />
                            <div class="field-error" id="typeError">
                                <svg viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                                </svg>
                                Please enter a project type.
                            </div>
                        </div>
                    </div>

                </div>
        

        <!-- ── CARD 3: Links ── -->
        <div class="card">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-icon">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z" />
                        </svg>
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
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12" />
                        </svg>
                        <input type="url" id="repository_link" name="repository_link" class="form-input"
                            placeholder="https://github.com/your-username/your-repo" oninput="updatePreview()"
                            onblur="validateUrl(this,'repoError')" />
                    </div>
                    <div class="field-error" id="repoError">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                        </svg>
                        Please enter a valid URL starting with https://
                    </div>
                </div>

                <!-- live_demo_link -->
                <div class="form-group">
                    <label class="form-label" for="live_demo_link">
                        Live Demo Link <span class="opt">(optional)</span>
                    </label>
                    <div class="input-icon-wrap">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm6.93 6h-2.95a15.65 15.65 0 00-1.38-3.56A8.03 8.03 0 0118.92 8zM12 4.04c.83 1.2 1.48 2.53 1.91 3.96h-3.82c.43-1.43 1.08-2.76 1.91-3.96zM4.26 14C4.1 13.36 4 12.69 4 12s.1-1.36.26-2h3.38c-.08.66-.14 1.32-.14 2s.06 1.34.14 2H4.26zm.82 2h2.95c.32 1.25.78 2.45 1.38 3.56A7.987 7.987 0 015.08 16zm2.95-8H5.08a7.987 7.987 0 014.33-3.56A15.65 15.65 0 008.03 8zM12 19.96c-.83-1.2-1.48-2.53-1.91-3.96h3.82c-.43 1.43-1.08 2.76-1.91 3.96zM14.34 14H9.66c-.09-.66-.16-1.32-.16-2s.07-1.35.16-2h4.68c.09.65.16 1.32.16 2s-.07 1.34-.16 2zm.25 5.56c.6-1.11 1.06-2.31 1.38-3.56h2.95a8.03 8.03 0 01-4.33 3.56zM16.36 14c.08-.66.14-1.32.14-2s-.06-1.34-.14-2h3.38c.16.64.26 1.31.26 2s-.1 1.36-.26 2h-3.38z" />
                        </svg>
                        <input type="url" id="live_demo_link" name="live_demo_link" class="form-input"
                            placeholder="https://your-live-demo.com" oninput="updatePreview()"
                            onblur="validateUrl(this,'demoError')" />
                    </div>
                    <div class="field-error" id="demoError">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                        </svg>
                        Please enter a valid URL starting with https://
                    </div>
                    <p class="form-hint">Add a Vercel, Railway, Heroku, or any hosted URL where people can try your
                        project.</p>
                </div>

            </div>
        </div>

        <!-- ── CARD 4: Specializations & Skills ── -->
        <div class="card">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z" />
                        </svg>
                    </div>
                    <div>
                        <div class="card-title">Specializations & Skills</div>
                        <div class="card-sub">Select your majors and relevant skills</div>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <!-- Specializations -->
                <div class="form-group">
                    <label class="form-label" for="specializations">
                        Specializations <span class="req">*</span>
                    </label>
                    <select id="specializations" name="specializations[]" multiple>
                        @foreach ($specializations as $specialization)
                            <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                        @endforeach
                    </select>
                    <p class="form-hint">Choose one or more specializations — available skills will load below.</p>
                </div>

                <!-- Skills -->
                <div class="form-group skills-form-group">
                    <label class="form-label">Skills</label>
                    <div id="skills-checkbox-container" class="skills-checkbox-grid">
                        <p class="form-hint">Please select a specialization to view available skills...</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- ── CARD 5: Team Members ── -->
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
                    <label class="form-label">Team Members <span class="opt">(optional)</span></label>
                    <div id="team-members-container" class="team-members-list">
                        <p class="form-hint">No team members added yet. Click the button below to add one.</p>
                    </div>
                    <button type="button" class="btn btn-secondary" onclick="addTeamMemberField()" style="margin-top: 12px;">
                        <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: currentColor; margin-right: 6px;">
                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                        </svg>
                        Add Team Member
                    </button>
                </div>
            </div>
        </div>

        <!-- ── CARD 6: Project Media ── -->
        <div class="card">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" />
                        </svg>
                    </div>
                    <div>
                        <div class="card-title">Project Media</div>
                        <div class="card-sub">Add images and videos to showcase your project</div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group media-form-group">
                    <label class="form-label">Upload Media <span class="opt">(optional)</span></label>
                    <div class="media-upload-notice">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                        </svg>
                        <span>The <strong>first image</strong> you upload will be used as your project's cover photo</span>
                    </div>
                    <input type="file" id="project_media" name="project_media[]" class="form-input media-input"
                        multiple accept="image/*,video/*" />
                    <p class="form-hint">Upload images or videos. Supported formats: JPG, PNG, GIF, WebP, MP4, WebM</p>
                    
                    <div id="media-preview-container" class="media-preview-grid" style="margin-top: 16px; display: none;">
                    </div>
                </div>
            </div>
        </div>

        <!-- ── LIVE PREVIEW ── -->
        <div class="preview-panel">
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

        <!-- ── FOOTER ── -->
        <div class="form-footer">
            <div class="footer-note">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z" />
                </svg>
                Data saved securely
            </div>
            <div class="footer-actions">
                <button type="button" class="btn btn-ghost" onclick="window.history.back()">Cancel</button>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    Publish Project
                    <svg viewBox="0 0 24 24">
                        <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
                    </svg>
                </button>
            </div>
        </div>

        </div>

        </form>
        </div>
    </main>

    <style>
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>

    <script src="{{ asset('js/project-add.js') }}"></script>
@endsection
