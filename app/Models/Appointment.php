<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Appointment extends Model
{
    protected $fillable = ['doctor_id', 'patient_id', 'start_time', 'end_time'];

    // Relationship with Doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // Relationship with Patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
