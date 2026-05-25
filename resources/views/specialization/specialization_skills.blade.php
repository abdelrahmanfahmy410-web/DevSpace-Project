<!DOCTYPE html>
<html lang="en">
<head>   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Specializations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        thead {
            background-color: #343a40;
            color: white;
        }
        th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        tbody tr:hover {
            background-color: #f9f9f9;
        }
        .skills-cell {
            color: #555;
        }
    </style>
</head>
<body>
    <div style="max-width: 1000px; margin: 0 auto;">
        <h1>Specializations</h1>
        <table>
            <thead>
                <tr>
                    <th>Specialization</th>
                    <th>Skills</th>
                </tr>
            </thead>
            <tbody>
                @foreach($specializations as $specialization)
                    <tr>
                        <td><strong>{{ $specialization->name }}</strong></td>
                        <td class="skills-cell">
                            @if($specialization->skills->count() > 0)
                                @foreach($specialization->skills as $skill)
                                    <span style="display: inline-block; background-color: #e9ecef; padding: 4px 8px; margin: 2px; border-radius: 4px;">
                                        {{ $skill->name }}
                                    </span>
                                @endforeach
                            @else
                                <em>No skills assigned</em>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>