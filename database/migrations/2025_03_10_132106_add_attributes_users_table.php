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
        // add attributes to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('rut', 10)->unique(); // RUT formato '26335451-6'
            $table->string('first_name', 100);
            $table->string('last_name', 100)->nullable();
            $table->string('mother_last_name', 100)->nullable();
            $table->string('father_last_name', 100)->nullable();
            $table->string('alias', 50)->nullable();
            $table->string('phone', 12)->nullable();
            $table->string('address', 150)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('avatar', 2083)->nullable();
            $table->string('avatar_original', 2083)->nullable();
            $table->string('preferred_name', 50)->nullable();
            $table->unsignedBigInteger('realm_id')->nullable(); // establecimiento
            $table->unsignedBigInteger('city_id')->nullable(); // comuna
            $table->unsignedBigInteger('region_id')->nullable(); // region
            $table->unsignedBigInteger('country_id')->nullable(); // pais
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
