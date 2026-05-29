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
        .container {
            max-width: 900px;
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
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }
        tbody tr:hover {
            background-color: #f8f9fa;
        }
        .empty-row td {
            text-align: center;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Specializations</h1>
        <table>
            <thead>
                <tr>
                    <th>Specialization</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($specializations as $specialization)
                    <tr>
                        <td>{{ $specialization->name }}</td>
                    </tr>
                @empty
                    <tr class="empty-row">
                        <td>No specializations available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>