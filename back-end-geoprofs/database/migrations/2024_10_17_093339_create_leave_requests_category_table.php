<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveRequestsCategoryTable extends Migration
{
    public function up()
    {
        Schema::create('leave_requests_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->boolean('is_paid');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leave_requests_categories');
    }
}
