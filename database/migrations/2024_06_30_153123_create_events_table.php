<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('thumbnail');
            $table->string('title');
            $table->string('description');
            $table->text('content');
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime')->nullable();
            $table->boolean('is_endedtime')->default(false);
            $table->bigInteger('user_id')->index();
            $table->timestamps();
        });

        Schema::create('event_attendance', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('event_id');
            $table->bigInteger('user_id');
            $table->boolean('is_present')->default(false);
            $table->boolean('is_read');
            $table->dateTime('read_time');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
        Schema::dropIfExists('event_attendance');
    }
};
