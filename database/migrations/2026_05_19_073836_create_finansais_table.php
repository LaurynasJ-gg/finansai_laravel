<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finansais', function (Blueprint $table) {
            $table->id();
            $table->string('tipas');
            $table->string('kategorija');
            $table->decimal('suma', 10, 2);
            $table->text('aprasymas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finansais');
    }
};
