<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('publishers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country');
            $table->year('founded');
            $table->string('genere');
            $table->timestamps();
        });
        
    }

    
    public function down(): void
    {
        Schema::dropIfExists('publishers');
    }
};
