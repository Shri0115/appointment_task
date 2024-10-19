<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Slot styles */
        .slot {
            width: 100px;
            height: 50px;
            margin: 10px;
            display: inline-block;
            text-align: center;
            line-height: 50px;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Available slot color */
        .slot.available {
            background-color: #4CAF50;
        }

        /* Hover effect for available slots */
        .slot.available:hover {
            background-color: #45a049;
            transform: translateY(-5px);
        }

        /* Booked slot color */
        .slot.booked {
            background-color: #9e9e9e;
            cursor: not-allowed;
        }

        /* Hover effect for booked slots */
        .slot.booked:hover {
            background-color: #9e9e9e;
        }

        .container {
            max-width: 800px;
            margin-top: 50px;
        }

        h1 {
            font-size: 36px;
            font-weight: bold;
            color: #333;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group select, .form-group input {
            border-radius: 15px;
            padding: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-group input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-group input[type="submit"]:hover {
            background-color: #45a049;
            transform: translateY(-3px);
        }

        .alert {
            margin-top: 20px;
        }

        /* Profile and logout button styles */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 10;
        }

        .navbar-nav {
            margin-left: auto;
        }

        .navbar-nav .nav-item {
            margin-left: 15px;
        }

        .navbar-nav .nav-link {
            color: #333 !important;
            font-weight: bold;
        }

        .navbar-nav .nav-link:hover {
            color: #4CAF50 !important;
        }
    </style>
</head>
<body>

    <!-- Navbar for Logout Button -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Appointment System</a>
            <!-- Logout Button Form -->
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="nav-item nav-link btn btn-link" style="border: none; background: none; color: #333; font-weight: bold;">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <h1 class="text-center">Book An Appointment</h1>

        {{-- Success Notification --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Error Notification --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <form action="{{ route('book-appointment') }}" method="POST">
            @csrf

            <!-- Doctor Selection -->
            <div class="form-group">
                <label for="doctor_id">Doctor</label>
                <select name="doctor_id" id="doctor_id" class="form-control">
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Appointment Date -->
            <div class="form-group">
                <label for="appointment_date">Date</label>
                <input type="date" name="appointment_date" id="appointment_date" class="form-control" required>
            </div>

            <h3 class="text-center">Choose a Time Slot</h3>

            <!-- Slot Selection -->
            <div class="d-flex justify-content-center flex-wrap">
                @foreach ($availableSlots as $slot)
                    <div class="slot {{ $slot['isBooked'] ? 'booked' : 'available' }}" 
                         data-time="{{ $slot['start'] }}">
                        {{ $slot['start'] }} - {{ $slot['end'] }}
                    </div>
                @endforeach
            </div>

            <div class="form-group">
                <input type="hidden" name="appointment_time" id="appointment_time">
                <input type="submit" value="Book Appointment" class="btn btn-primary" disabled>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js (required for Bootstrap functionality) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.querySelectorAll('.slot').forEach(slot => {
            slot.addEventListener('click', function() {
                if (!this.classList.contains('booked')) {
                    // Only store the start time (e.g., 19:00) in the hidden field
                    document.getElementById('appointment_time').value = this.dataset.time;
                    document.querySelector('form input[type="submit"]').disabled = false;
                }
            });
        });
    </script>

</body>
</html>
