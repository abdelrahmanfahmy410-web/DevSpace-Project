/**
 * DevSpace Project Add Form
 * Handles project type autocomplete, specialization skills loading, and form validation
 */

(function () {
  

  // ─────────────────────────────────────────────────────────────────────────
  // SPECIALIZATIONS & SKILLS LOADER
  // ─────────────────────────────────────────────────────────────────────────

  const specializationSelect = new TomSelect("#specializations", {
    plugins: ["remove_button"],
    create: false,
    placeholder: "Choose your majors...",
    onChange: function (values) {
      loadSkills(values);
    },
  });

  /**
   * Load skills for selected specializations
   */
  function loadSkills(specIds) {
    const container = document.getElementById("skills-checkbox-container");

    if (!specIds || specIds.length === 0) {
      container.innerHTML = '<p class="form-hint">Please select a specialization to view available skills...</p>';
      return;
    }

    container.innerHTML = '<p class="form-hint" style="color:#6b7280;">Loading skills…</p>';

    const fetchPromises = specIds.map((specId) =>
      fetch(`/api/skills-by-specialization/${specId}`)
        .then((response) => {
          if (!response.ok) throw new Error("Network error");
          return response.json();
        })
    );

    Promise.all(fetchPromises)
      .then((results) => {
        container.innerHTML = "";
        const allSkills = [];
        const uniqueIds = new Set();

        results.forEach((skillsArray) => {
          skillsArray.forEach((skill) => {
            if (!uniqueIds.has(skill.id)) {
              uniqueIds.add(skill.id);
              allSkills.push(skill);
            }
          });
        });

        if (allSkills.length > 0) {
          allSkills.forEach((skill) => {
            const label = document.createElement("label");
            label.className = "skill-checkbox-item";

            const checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.name = "skills[]";
            checkbox.value = skill.id;

            label.appendChild(checkbox);
            label.appendChild(document.createTextNode(" " + skill.name));
            container.appendChild(label);
          });
        } else {
          container.innerHTML =
            '<p class="form-hint" style="color:#ef4444;">No skills found for these specializations.</p>';
        }
      })
      .catch((error) => {
        console.error("Error fetching skills:", error);
        container.innerHTML =
          '<p class="form-hint" style="color:#ef4444;">Error loading skills. Please try again.</p>';
      });
  }

  // ─────────────────────────────────────────────────────────────────────────
  // FORM INTERACTIONS
  // ─────────────────────────────────────────────────────────────────────────

  /**
   * Update character count for title
   */
  window.onTitleInput = function (el) {
    const count = document.getElementById("titleCount");
    count.textContent = el.value.length;
    count.parentElement.classList.toggle("over", el.value.length > 95);
    updatePreview();
  };

  /**
   * Update character count for description
   */
  window.onDescInput = function (el) {
    const count = document.getElementById("descCount");
    count.textContent = el.value.length;
    count.parentElement.classList.toggle("over", el.value.length > 1900);
    updatePreview();
  };

  /**
   * Validate URL input
   */
  window.validateUrl = function (input, errorId) {
    const err = document.getElementById(errorId);
    if (input.value && !input.value.startsWith("https://")) {
      input.classList.add("error");
      err.classList.add("show");
    } else {
      input.classList.remove("error");
      err.classList.remove("show");
    }
    updatePreview();
  };

  /**
   * Update live preview
   */
  window.updatePreview = function () {
    const title = document.getElementById("title").value.trim();
    const desc = document.getElementById("description").value.trim();
    const type = document.getElementById("type_input").value;
    const repo = document.getElementById("repository_link").value.trim();
    const demo = document.getElementById("live_demo_link").value.trim();

    const words = title.split(/\s+/).filter(Boolean);
    const avatarText =
      words.length >= 2
        ? words[0][0].toUpperCase() + words[1][0].toUpperCase()
        : title.slice(0, 2).toUpperCase() || "DS";

    document.getElementById("previewAv").textContent = avatarText;
    document.getElementById("previewName").textContent = title || "Your Project Title";
    document.getElementById("previewType").textContent = type || "Select a type above";
    document.getElementById("previewDesc").textContent = desc
      ? desc.length > 120
        ? desc.slice(0, 120) + "…"
        : desc
      : "Your description will appear here…";

    const linksEl = document.getElementById("previewLinks");
    linksEl.innerHTML = "";

    if (repo) {
      linksEl.innerHTML += `<span class="preview-link">
        <svg viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
        Repository
      </span>`;
    }

    if (demo) {
      linksEl.innerHTML += `<span class="preview-link">
        <svg viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm6.93 6h-2.95a15.65 15.65 0 00-1.38-3.56A8.03 8.03 0 0118.92 8z"/></svg>
        Live Demo
      </span>`;
    }
  };

  // ─────────────────────────────────────────────────────────────────────────
  // FORM SUBMISSION & VALIDATION
  // ─────────────────────────────────────────────────────────────────────────

  /**
   * Form validation
   */
  document.getElementById("projectForm").addEventListener("submit", function (e) {
    let isValid = true;

    // Validate title
    const title = document.getElementById("title");
    const titleErr = document.getElementById("titleError");
    if (!title.value.trim()) {
      title.classList.add("error");
      titleErr.classList.add("show");
      isValid = false;
    } else {
      title.classList.remove("error");
      titleErr.classList.remove("show");
    }

    // Validate description
    const desc = document.getElementById("description");
    const descErr = document.getElementById("descError");
    if (!desc.value.trim()) {
      desc.classList.add("error");
      descErr.classList.add("show");
      isValid = false;
    } else {
      desc.classList.remove("error");
      descErr.classList.remove("show");
    }

    // Validate type
    const typeVal = document.getElementById("type_input").value;
    const typeErr = document.getElementById("typeError");
    if (!typeVal) {
      typeErr.classList.add("show");
      isValid = false;
    } else {
      typeErr.classList.remove("show");
    }

    if (!isValid) {
      e.preventDefault();
      return;
    }

    // Update submit button state
    const btn = document.getElementById("submitBtn");
    btn.disabled = true;
    btn.innerHTML = `
      <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor" style="animation:spin 0.8s linear infinite">
        <path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
      </svg>
      Publishing…
    `;
  });

  /**
   * Remove error state on input
   */
  document.getElementById("title").addEventListener("input", function () {
    this.classList.remove("error");
    document.getElementById("titleError").classList.remove("show");
  });

  document.getElementById("description").addEventListener("input", function () {
    this.classList.remove("error");
    document.getElementById("descError").classList.remove("show");
  });

  // ─────────────────────────────────────────────────────────────────────────
  // TEAM MEMBERS
  // ─────────────────────────────────────────────────────────────────────────

  let teamMemberCount = 0;

  /**
   * Add a new team member form field with Tom Select user search
   */
  window.addTeamMemberField = function () {
    const container = document.getElementById("team-members-container");
    
    // Hide the placeholder message if visible
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
        <input type="text" id="${id}-role" name="team_members[${teamMemberCount}][role]" class="form-input" placeholder="e.g. Frontend Developer" />
      </div>
      <button type="button" class="team-member-remove" onclick="removeTeamMember('${id}')" aria-label="Remove team member">✕</button>
    `;

    container.appendChild(item);

    // Initialize Tom Select for user search
    new TomSelect("#" + selectId, {
      valueField: "value",
      labelField: "text",
      searchField: "text",
      placeholder: "Search and select a user…",
      load: function (query, callback) {
        if (!query.length) return callback();

        fetch(`/api/users/search?q=${encodeURIComponent(query)}`)
          .then((response) => response.json())
          .then((data) => callback(data))
          .catch(() => callback());
      },
    });
  };

  /**
   * Remove a team member field
   */
  window.removeTeamMember = function (id) {
    const item = document.getElementById(id);
    if (item) item.remove();

    // Show placeholder if no team members left
    const container = document.getElementById("team-members-container");
    if (container.children.length === 0) {
      container.innerHTML = '<p class="form-hint">No team members added yet. Click the button below to add one.</p>';
    }
  };

  // ─────────────────────────────────────────────────────────────────────────
  // PROJECT MEDIA
  // ─────────────────────────────────────────────────────────────────────────

  const mediaInput = document.getElementById("project_media");
  const mediaPreviewContainer = document.getElementById("media-preview-container");

  if (mediaInput) {
    mediaInput.addEventListener("change", function (e) {
      const files = Array.from(e.target.files);
      
      if (files.length === 0) {
        mediaPreviewContainer.innerHTML = "";
        mediaPreviewContainer.style.display = "none";
        return;
      }

      mediaPreviewContainer.innerHTML = "";
      mediaPreviewContainer.style.display = "grid";

      files.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function (event) {
          const preview = document.createElement("div");
          preview.className = "media-preview-item";
          preview.id = "media-preview-" + index;

          const isVideo = file.type.startsWith("video/");
          const mediaElement = document.createElement(isVideo ? "video" : "img");
          mediaElement.src = event.target.result;

          if (isVideo) {
            mediaElement.controls = false;
          }

          preview.appendChild(mediaElement);

          const removeBtn = document.createElement("button");
          removeBtn.type = "button";
          removeBtn.className = "media-preview-remove";
          removeBtn.textContent = "✕";
          removeBtn.onclick = function () {
            removeMediaFile(index);
          };

          preview.appendChild(removeBtn);
          mediaPreviewContainer.appendChild(preview);
        };

        reader.readAsDataURL(file);
      });
    });
  }

  /**
   * Remove a media file from preview
   */
  window.removeMediaFile = function (index) {
    const preview = document.getElementById("media-preview-" + index);
    if (preview) preview.remove();

    // Clear file input and rebuild
    if (mediaInput && mediaInput.files.length > 0) {
      const dt = new DataTransfer();
      const files = Array.from(mediaInput.files);
      files.forEach((file, i) => {
        if (i !== index) dt.items.add(file);
      });
      mediaInput.files = dt.files;
      mediaInput.dispatchEvent(new Event("change"));
    }
  };
})();
