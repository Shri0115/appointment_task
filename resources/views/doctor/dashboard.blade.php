<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>

    <!-- Google Fonts for better typography -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        /* General Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            background-color: #1e3d58;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        h1 {
            margin: 0;
            font-size: 32px;
        }

        /* Form Styles */
        form {
            margin: 30px 0;
            text-align: center;
        }

        input[type="date"] {
            padding: 10px;
            margin: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            width: 150px;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 14px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Table Styles */
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #1e3d58;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Status Column Styles */
        .status {
            font-weight: bold;
        }

        .status.completed {
            color: green;
        }

        .status.pending {
            color: orange;
        }

        .status.cancelled {
            color: red;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            h1 {
                font-size: 28px;
            }

            input[type="date"] {
                width: 120px;
            }

            button[type="submit"] {
                font-size: 12px;
            }

            table {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            input[type="date"] {
                width: 100px;
            }

            button[type="submit"] {
                padding: 8px 15px;
            }
        }
    </style>
</head>
<body>

    <header>
        <h1>Doctor Dashboard</h1>
    </header>

    <div class="container">
        <form method="GET">
            <label for="from_date">From Date: </label>
            <input type="date" name="from_date" required>

            <label for="to_date">To Date: </label>
            <input type="date" name="to_date" required>

            <button type="submit">Filter</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Appointment Date</th>
                    <th>Appointment Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <!-- Check if patient is not null -->
                        <td>{{ $appointment->patient_name }}</td>
                        <td>{{ $appointment->appointment_date }}</td>
                        <td>{{ $appointment->appointment_time }}</td>
                        <td class="status {{ strtolower($appointment->status) }}">
                            {{ $appointment->status }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
