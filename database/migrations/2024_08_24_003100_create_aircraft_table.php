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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 50)->unique();
            $table->string('value', 100)->nullable();
            $table->timestamps();
        });
        
        Schema::create('aircraft_types', function (Blueprint $table) {
            $table->id();
            $table->string('aircraft_type');
            $table->string('manufacturer');
            $table->integer('max_zero_fuel_weight');
            $table->integer('max_takeoff_weight');
            $table->integer('max_landing_weight');
            $table->integer('deck_crew')->nullable();
            $table->integer('cabin_crew')->nullable();
            $table->integer('passenger_zones')->nullable();
            $table->integer('max_fuel_weight')->nullable();
            $table->decimal('fwd_cg_limit', 5, 2)->nullable();
            $table->decimal('aft_cg_limit', 5, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number');
            $table->integer('basic_weight');
            $table->decimal('basic_index', 5, 2);
            $table->foreignId('aircraft_type_id')->constrained()->onDelete('cascade');
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
            $table->integer('block_fuel');
            $table->integer('taxi_fuel');
            $table->integer('trip_fuel');
            $table->string('crew');
            $table->string('pantry');
            $table->timestamps();
        });

        Schema::create('loadsheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flight_id')->constrained()->onDelete('cascade');
            $table->integer('total_traffic_load')->default(0);
            $table->integer('dry_operating_weight')->default(0);
            $table->integer('zero_fuel_weight_actual')->default(0);
            $table->integer('take_off_fuel')->default(0);
            $table->integer('take_off_weight_actual')->default(0);
            $table->integer('trip_fuel')->default(0);
            $table->integer('landing_weight_actual')->default(0);
            $table->json('compartment_loads');
            $table->json('passenger_distribution');
            $table->timestamps();
        });

        Schema::create('envelopes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aircraft_type_id')->constrained()->onDelete('cascade');
            $table->string('envelope_type');
            $table->decimal('x', 5, 2);
            $table->decimal('y', 5, 2);
            $table->timestamps();
        });

        Schema::create('holds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aircraft_type_id')->constrained()->onDelete('cascade');
            $table->string('hold_no');
            $table->float('fwd')->nullable();
            $table->float('aft')->nullable();
            $table->float('max')->nullable();
            $table->decimal('index_per_kg', 5, 5)->nullable();
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

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flight_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('content');
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
