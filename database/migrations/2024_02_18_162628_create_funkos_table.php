<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('funkos', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->float('price')->nullable(false);
            $table->integer('stock')->nullable(false);
            $table->string('image')->default('https://placehold.co/150x150');
            $table->foreignIdFor(Category::class, 'category_id')->constrained('categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funkos');
    }
};
