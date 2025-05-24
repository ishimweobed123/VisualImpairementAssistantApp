<!DOCTYPE html>
<html>
<head>
    <title>Activity Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>VisualImpairedAssistance Activity Report</h1>
    <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Log Name</th>
                <th>Description</th>
                <th>User</th>
                <th>Subject Type</th>
                <th>Subject ID</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->log_name }}</td>
                    <td>{{ $log->description }}</td>
                    <td>{{ $log->causer ? $log->causer->name : 'N/A' }}</td>
                    <td>{{ $log->subject_type ?? 'N/A' }}</td>
                    <td>{{ $log->subject_id ?? 'N/A' }}</td>
                    <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>