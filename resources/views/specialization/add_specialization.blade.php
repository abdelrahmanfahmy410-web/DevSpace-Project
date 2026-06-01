<!DOCTYPE html>
<html lang="en">
<head>
         <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Specialization</title>
        <link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>
<body>
    <div>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
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

    <label for="specialization">
        Specialization
    </label>

    <select
        id="specialization"
        class="form-control"
        name="name"
        required
    onchange="showspecilization()"
    >

        <option disabled selected>
            Select Specialization
        </option>


        @foreach($specializations as $specialization)

            <option value="{{ $specialization->name }}">

                {{ $specialization->name }}

            </option>
            @endforeach
            <option value="Other" >

                Other
             </option>


    </select>
  <div  id="other-specialization" style="display:none; margin-top:10px;">
    
       <input
            type="text"
            name="other_specialization"
            class="form-control"
            placeholder="Enter other specialization"
        >
            
       
    </div>
</div>


<div class="form-group">

    <label>
        Skills
    </label>

    <div class="skills-container">

        @foreach($skills as $skill)

            <div class="skill-item">

                <input
                    type="checkbox"
                    name="skills[]"
                    value="{{ $skill->id }}"
                >

                <label>

                    {{ $skill->name }}

                </label>

            </div>

        @endforeach

    </div>

</div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    Create Specialization
                </button>
</div>

</body>
<script>
function showspecilization() {

    var specialization =
        document.getElementById("specialization").value;

    if (specialization == "Other") {
        document.getElementById("other-specialization").style.display = "block";
    } else {
        document.getElementById("other-specialization").style.display = "none";
    }
}
</script>
</html>
