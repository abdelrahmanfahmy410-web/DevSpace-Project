<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skills</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Skills</h1>
        <table>
            <thead>
                <tr>
                    <th>Skill Name</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($skills as $skill)
                    <tr>
                        <td>{{ $skill->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td style="text-align: center; color: #999;">No skills available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>