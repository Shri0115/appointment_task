<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Support\Facades\Session;  // Import the Session facade



class DoctorController extends Controller
{

    public function dashboard(Request $request)
    {
        $doctorId = auth()->user()->id;
        
        // Apply date filters if provided
        $appointments = Appointment::with('patient') // Eager load the patient relationship
            ->where('doctor_id', $doctorId)
            ->when($request->has('from_date') && $request->has('to_date'), function ($query) use ($request) {
                return $query->whereBetween('appointment_date', [$request->from_date, $request->to_date]);
            })
            ->get();

        return view('doctor.dashboard', compact('appointments'));
    }


}
