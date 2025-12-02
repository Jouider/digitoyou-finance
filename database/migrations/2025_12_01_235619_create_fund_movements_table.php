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
        Schema::create('fund_movements', function (Blueprint $table) {
            $table->id();
            $table->enum('person', ['abdellah', 'mouad', 'agency']); // Qui est concerné
            $table->enum('type', ['entree', 'sortie', 'distribution', 'versement_agence']); // Type de mouvement
            $table->decimal('amount', 10, 2);
            $table->string('description');
            $table->foreignId('project_payment_id')->nullable()->constrained()->onDelete('set null'); // Lien avec paiement client
            $table->foreignId('expense_id')->nullable()->constrained()->onDelete('set null'); // Lien avec une charge
            $table->foreignId('profit_distribution_id')->nullable()->constrained()->onDelete('set null'); // Lien avec distribution
            $table->date('movement_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fund_movements');
    }
};
