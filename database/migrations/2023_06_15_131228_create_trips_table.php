<?php

use App\Constants\Enum;
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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('captain_id')->nullable()->constrained('users');
            $table->foreignId('owner_id')->nullable()->constrained('users'); // place or customer
            $table->foreignId('complete_trip_daily_id')->nullable()->constrained('complete_trip_dailies');
            $table->boolean('is_owner_place')->default(false);
            $table->text('from')->nullable();
            $table->text('to')->nullable();
            $table->text('amount')->nullable(); //اذا كان في قيمة يعني مسكر الطلب بمفهوم المكتب
            $table->enum('payment_type',[Enum::IMMEDIATELY,Enum::POSTPAID])->default(Enum::IMMEDIATELY);
            $table->enum('type',[Enum::IMMEDIATELY,Enum::LATER])->default(Enum::IMMEDIATELY); //نوع الانطلاق
            $table->timestamp('come_at')->nullable();
            $table->boolean('customer_paid')->default(false); // انا حاسبت الزبون واعطيته
            $table->boolean('place_paid')->default(false); // انا حاسبت المكان واخذت منه
            $table->enum('status', [Enum::PENDING, Enum::COMPLETED, Enum::CANCELED])->default(Enum::PENDING);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
