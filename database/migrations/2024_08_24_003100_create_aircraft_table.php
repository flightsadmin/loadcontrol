<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration');
            $table->float('empty_weight');
            $table->float('max_takeoff_weight');
            $table->float('fuel_capacity');
            $table->float('cg_range_min');
            $table->float('cg_range_max');
            $table->timestamps();
        });

        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->onDelete('cascade');
            $table->string('flight_number');
            $table->string('origin');
            $table->string('destination');
            $table->string('airline');
            $table->enum('flight_type', ['Domestic', 'International']);
            $table->timestamp('departure');
            $table->timestamp('arrival');
            $table->timestamps();
        });

        Schema::create('passengers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flight_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['male', 'female', 'child', 'infant']);
            $table->integer('count');
            $table->string('zone');
            $table->timestamps();
        });

        Schema::create('fuel_figures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flight_id')->constrained()->onDelete('cascade');
            $table->double('block_fuel');
            $table->double('taxi_fuel');
            $table->double('trip_fuel');
            $table->string('crew');
            $table->integer('pantry');
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flight_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('content');
            $table->timestamps();
        });

        Schema::create('loadsheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flight_id')->constrained()->onDelete('cascade');
            $table->decimal('total_deadload_weight', 8, 2);
            $table->decimal('total_passengers_weight', 8, 2);
            $table->decimal('total_fuel_weight', 8, 2);
            $table->decimal('gross_weight', 8, 2);
            $table->string('balance');
            $table->timestamps();
        });

        Schema::create('holds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->onDelete('cascade');
            $table->string('hold_no');
            $table->float('fwd');
            $table->float('aft');
            $table->text('restrictions')->nullable();
            $table->timestamps();
        });

        Schema::create('cargos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flight_id')->constrained()->onDelete('cascade');
            $table->foreignId('hold_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('type', ['baggage', 'cargo', 'mail'])->nullable();
            $table->float('pieces');
            $table->float('weight');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
