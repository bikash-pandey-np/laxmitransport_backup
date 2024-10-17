<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('load_type')->default('parcel')
                ->comment('parcel, ltl', 'truckload');
            $table->string('identifier')->unique();
            $table->string('origin');
            $table->string('destination')->nullable();
            $table->date('pickup_date')->nullable();
            $table->string('instructions')->nullable();

            $table->string('status')->default('pending')
                ->comment('pending, accepted, rejected');

            $table->foreignId('shipper_id')->constrained('shippers');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotes');
    }
};
