<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventPlanTable extends Migration
{
    public function up(): void
    {
        Schema::create('event_plan', function (Blueprint $table) {
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('planner_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->primary(['event_id', 'planner_id']); // clé composée
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_plan');
    }
}