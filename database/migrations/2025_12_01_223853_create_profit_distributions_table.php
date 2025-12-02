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
        Schema::create('profit_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->decimal('total_profit', 10, 2);
            $table->decimal('agency_share', 10, 2);
            $table->decimal('sadaqah_share', 10, 2);
            $table->decimal('abdellah_share', 10, 2);
            $table->decimal('mouad_share', 10, 2);
            $table->decimal('agency_percentage', 5, 2)->default(10.00);
            $table->decimal('sadaqah_percentage', 5, 2)->default(2.50);
            $table->date('distribution_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profit_distributions');
    }
};
