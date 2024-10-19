<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('doctor_name')->nullable();  // Add doctor_name column
            $table->string('patient_name')->nullable();  // Add patient_name column
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('doctor_name');
            $table->dropColumn('patient_name');
        });
    }

};
