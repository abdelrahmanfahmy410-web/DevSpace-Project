<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Role</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/add-role.css') }}">
</head>
<body>
    <div class="register-page">
        <div class="register-container">
            <div class="register-header">
                <div class="register-eyebrow"><span class="eyebrow-dot"></span>Role Management</div>
                <h1 class="register-title">Create New Role</h1>
                <p class="register-subtitle">Add a new role to DevSpace</p>
            </div>

            <form method="POST" action="/role/add_role" enctype="multipart/form-data">
                @csrf

                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon">📋</div>
                        <div>
                            <div class="form-card-title">Role Details</div>
                            <div class="form-card-sub">Provide the name of the role</div>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <div class="form-group">
                            <label for="name" class="form-label">Role Name <span class="required">*</span></label>
                            <input id="name" type="text" name="name" class="form-input" required autofocus>
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <p class="form-footer-note">🔒 Your data is encrypted and secure</p>
                    <div class="form-footer-actions">
                        <button type="submit" class="btn btn-primary">Create Role</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>