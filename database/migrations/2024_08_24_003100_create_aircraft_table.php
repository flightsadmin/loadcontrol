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
        Schema::create('airlines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('iata_code', 3);
            $table->string('base');
            $table->string('base_iata_code', 3);
            $table->json('settings')->nullable();
            $table->timestamps();
        });

        Schema::create('aircraft_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('airline_id')->constrained()->onDelete('cascade');
            $table->string('aircraft_type');
            $table->string('manufacturer');
            $table->integer('max_zero_fuel_weight');
            $table->integer('max_takeoff_weight');
            $table->integer('max_landing_weight');
            $table->string('config')->nullable();
            $table->integer('deck_crew')->nullable();
            $table->integer('cabin_crew')->nullable();
            $table->float('ref_sta')->nullable();
            $table->float('k_constant')->nullable();
            $table->float('c_constant')->nullable();
            $table->float('length_of_mac')->nullable();
            $table->float('lemac')->nullable();
            $table->json('settings')->nullable();
            $table->timestamps();
        });

        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number');
            $table->integer('basic_weight');
            $table->decimal('basic_index', 8, 2);
            $table->foreignId('aircraft_type_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('fuel_index', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aircraft_type_id')->constrained()->onDelete('cascade');
            $table->string('weight')->nullable();
            $table->decimal('index', 8, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('origin');
            $table->string('destination');
            $table->time('flight_time')->nullable();
            $table->foreignId('airline_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('flight_number');
            $table->foreignId('registration_id')->constrained()->onDelete('cascade');
            $table->foreignId('airline_id')->constrained()->onDelete('cascade');
            $table->foreignId('route_id')->constrained()->onDelete('cascade');
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
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->boolean('final')->default(false);
            $table->integer('edition')->default(0);
            $table->json('payload_distribution')->nullable();
            $table->timestamps();
        });

        Schema::create('envelopes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aircraft_type_id')->constrained()->onDelete('cascade');
            $table->string('envelope_type');
            $table->float('index');
            $table->float('weight');
            $table->timestamps();
        });

        Schema::create('holds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aircraft_type_id')->constrained()->onDelete('cascade');
            $table->string('hold_no');
            $table->float('fwd')->nullable();
            $table->float('aft')->nullable();
            $table->float('max')->nullable();
            $table->decimal('arm', 8, 5)->nullable();
            $table->decimal('index', 8, 5)->nullable();
            $table->timestamps();
        });

        Schema::create('cabin_zones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aircraft_type_id')->constrained()->onDelete('cascade');
            $table->string('zone_name')->nullable();
            $table->float('max_capacity')->nullable();
            $table->decimal('index', 8, 5)->nullable();
            $table->decimal('arm', 8, 5)->nullable();
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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->timestamps();
        });

        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('subject');
            $table->longText('body');
            $table->timestamps();
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->foreignId('airline_id')->constrained()->onDelete('cascade');
            $table->foreignId('route_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropAllTables();
    }
};
