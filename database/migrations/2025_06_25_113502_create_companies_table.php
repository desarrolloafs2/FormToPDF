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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('cif')->unique();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('legal_form')->nullable();
            $table->string('cnae')->nullable();
            $table->date('last_balance_date')->nullable();
            $table->string('status')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('ceo_name')->nullable();
            $table->string('ceo_position')->nullable();
            $table->decimal('capital', 15, 2)->nullable();
            $table->decimal('sales', 15, 2)->nullable();
            $table->integer('sales_year')->nullable();
            $table->integer('employees')->nullable();
            $table->date('founded_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
