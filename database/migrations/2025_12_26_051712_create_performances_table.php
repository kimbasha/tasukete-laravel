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
        Schema::create('performances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('troupe_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('venue');
            $table->enum('area', ['下北沢', '新宿', '渋谷', '池袋', 'その他']);
            $table->string('area_detail', 100)->nullable();
            $table->date('performance_date');
            $table->time('start_time');
            $table->time('door_open_time')->nullable();
            $table->string('poster_image_url')->nullable();
            $table->integer('ticket_price');
            $table->string('reservation_url')->nullable();
            $table->boolean('has_day_tickets')->default(false);
            $table->enum('status', ['upcoming', 'today', 'ended'])->default('upcoming');
            $table->timestamps();

            $table->index('troupe_id');
            $table->index('performance_date');
            $table->index('area');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performances');
    }
};
