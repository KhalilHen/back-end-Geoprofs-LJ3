<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['employee', 'manager', 'section-Manager', 'CEO']);
            $table->integer('leave_hours')->default(0);
            $table->enum('onLeave', ['present', 'on leave', 'sick', 'irresponsibly absent']);
            $table->double('average_hours');
            $table->date('date_of_birth');
            $table->date('start_working_date');
            $table->date('end_working_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
