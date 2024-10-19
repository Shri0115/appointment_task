<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;  // Import the Session facade

class PatientController extends Controller
{
    public function showSlots(Request $request)
{
    $doctors = User::where('role', 'doctor')->get();
    $bookedSlots = Appointment::select('appointment_time', 'appointment_date')
                            ->whereDate('appointment_date', $request->appointment_date)
                            ->get();

    // Prepare the available slots from 9:00 AM to 2:00 PM and 5:00 PM to 8:00 PM
    $availableSlots = [];
    $timeslots = [
        '9:00' => '10:00',
        '10:00' => '11:00',
        '11:00' => '12:00',
        '12:00' => '1:00',
        '1:00' => '2:00',
        '5:00' => '6:00',
        '6:00' => '7:00',
        '7:00' => '8:00',
    ];

    foreach ($timeslots as $start => $end) {
        $isBooked = Appointment::where('appointment_date', $request->appointment_date)
                               ->where('appointment_time', $start)
                               ->count() >= 2; // If 2 appointments are already taken, it's fully booked
        $availableSlots[] = [
            'start' => $start,
            'end' => $end,
            'isBooked' => $isBooked
        ];
    }

    return view('patient.book', compact('doctors', 'availableSlots'));
}
    // Check if the slot is fully booked (i.e., 2 appointments already taken)
    private function isSlotBooked($startTime, $endTime, $bookedSlots)
    {
        // Loop through booked slots and check if the time range is already fully booked
        $slotKey = $startTime . ' ' . $endTime;

        // Check if the slot key exists in the booked slots array
        if (isset($bookedSlots[$slotKey]) && count($bookedSlots[$slotKey]) >= 2) {
            return true;
        }

        return false;
    }

    public function bookAppointment(Request $request)
    {
        // Validate that no more than 2 appointments can be booked for the same time slot
        $existingAppointmentsCount = Appointment::where('appointment_date', $request->appointment_date)
                                                ->where('appointment_time', $request->appointment_time)
                                                ->count();
    
        if ($existingAppointmentsCount >= 2) {
            return redirect()->back()->with('error', 'This time slot is already fully booked. Please choose another slot.');
        }
    
        // Fetch patient and doctor details
        $patient = auth()->user(); // Since the patient is logged in
        $doctor = User::find($request->doctor_id); // Find doctor by doctor_id
    
        // Create new appointment and save patient and doctor names
        $appointment = new Appointment();
        $appointment->doctor_id = $request->doctor_id;
        $appointment->patient_id = $patient->id;
        $appointment->appointment_date = $request->appointment_date;
        $appointment->appointment_time = $request->appointment_time;
        $appointment->status = 'Pending';
    
        // Save patient and doctor names from the User table
        $appointment->patient_name = $patient->name;
        $appointment->doctor_name = $doctor->name;
    
        // Save the appointment to the database
        $appointment->save();
    
        return redirect()->back()->with('success', 'Appointment booked successfully.');
    }
}
