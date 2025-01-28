<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Requests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .button {
            padding: 5px 10px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .decline-button {
            background-color: #dc3545;
        }

        .decline-button:hover {
            background-color: #a71d2a;
        }
    </style>
</head>

<body>
    <h1>Leave Requests</h1>

    <p>Welcome, <strong>{{ $currentUser['name'] }}</strong>! (Role: {{ $currentUser['role'] }})</p>

    @if (count($leaveRequests) > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Employee Name</th>
                    <th>Employee Role</th>
                    <th>Leave Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leaveRequests as $request)
                    <tr>
                        <td>{{ $request['id'] }}</td>
                        <td>{{ $request['title'] }}</td>
                        <td>{{ $mockUsers[$request['employee_id']]['name'] ?? 'Unknown' }}</td>
                        <td>{{ $mockUsers[$request['employee_id']]['role'] ?? 'Unknown' }}</td>
                        <td>{{ $request['leave_status'] }}</td>
                        <td>
                            <form method="POST" action="{{ route('leave.requests.decline', $request['id']) }}"
                                style="display: inline;">
                                @csrf
                                <button type="submit" class="button decline-button">Decline</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No leave requests found.</p>
    @endif
</body>

</html>