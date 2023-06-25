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
        Schema::create('complete_trip_dailies', function (Blueprint $table) {
            $table->id();
            $table->double('fix_amount')->nullable();
            $table->double('ratio')->nullable();
            $table->json('ids_trips')->nullable();
            $table->double('total_amount')->nullable();
            $table->double('total_amount_for_captain')->nullable();
            $table->double('total_amount_for_office')->nullable();
            $table->foreignId('captain_id')->nullable()->constrained('users');
            $table->date('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complete_trip_dailies');
    }
};
