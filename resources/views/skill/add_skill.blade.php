<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Skill</title>
        <link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>
<body>
<div class="page-wrap">
    <div class="page-header">
        <span class="badge">SKILL</span>
        <h1 class="title">Create Skill</h1>
        <div class="subtitle">Add a new skill to DevSpace</div>
    </div>

    <div class="card">
        <div class="card-title">Skill </div>
        <div class="card-sub">Provide the name of the skill</div>

        <form method="POST" action="/skill/add_skill" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" class="form-control" type="text" name="name" required autofocus>
            </div>


            <div class="footer-row">
                <button class="btn" type="submit">Create Skill</button>
            </div>
        </form>
    </div>

</div>

</body>
</html>
