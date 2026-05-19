<!DOCTYPE html>
<html lang="en">
<head>
         <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Specialization</title>
        <link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>
<body>
<div class="page-wrap">
    <div class="page-header">
        <span class="badge">SPECIALIZATION</span>
        <h1 class="title">Create Specialization</h1>
        <div class="subtitle">Add a new specialization to DevSpace</div>
    </div>

    <div class="card">
        <div class="card-title">Specialization Details</div>
        <div class="card-sub">Provide the specialization name to be displayed</div>

        <form method="POST" action="/specialization/add_specialization" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" class="form-control" type="text" name="name" required autofocus>
            </div>

            <div class="footer-row">
                <button class="btn" type="submit">Create Specialization</button>
            </div>
        </form>
    </div>

</div>

</body>
</html>