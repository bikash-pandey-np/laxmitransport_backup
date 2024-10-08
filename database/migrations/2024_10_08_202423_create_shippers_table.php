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
        Schema::create('shippers', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('code')->unique();
            $table->string('vat_no')->nullable()->unique();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->foreignId('state_id')->constrained('states');
            $table->foreignId('district_id')->constrained('districts');
            $table->foreignId('localbody_id')->constrained('local_bodies');
            $table->string('street_address');
            $table->string('ward_no');
            $table->string('password');

            $table->boolean('is_active')->default(true);
            $table->boolean('is_email_verified')->default(false);
            $table->boolean('is_phone_verified')->default(false);

            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();

            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('shippers');
    }
};
