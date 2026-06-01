<div class="project-media-section">
	<h3>Add Project Media</h3>

	<p class="text-muted">Note: the first picture you upload will be used as the project's cover image.</p>

	<form action="{{ isset($project) ? route('projects.media.store', $project->id) : '#' }}" method="POST" enctype="multipart/form-data">
		@csrf

		<div class="form-group">
			<label for="media">Upload images / videos</label>
			<input type="file" name="media[]" id="media" multiple accept="image/*,video/*" class="form-control">
			<small class="form-text text-muted">You may select multiple files. The first image will become the cover.</small>
		</div>

		<button type="submit" class="btn btn-primary mt-2">Upload Media</button>
	</form>
</div>

