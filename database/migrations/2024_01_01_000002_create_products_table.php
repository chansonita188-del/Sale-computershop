<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('brand');
            $table->string('model');
            $table->string('product_type')->default('computer');
            $table->string('cpu_brand')->nullable();
            $table->string('cpu_model')->nullable();
            $table->decimal('cpu_speed', 5, 2)->nullable();
            $table->integer('cpu_cores')->nullable();
            $table->string('gpu_brand')->nullable();
            $table->string('gpu_model')->nullable();
            $table->string('ram_size')->nullable();
            $table->string('ram_type')->nullable();
            $table->string('storage')->nullable();
            $table->string('storage_type')->nullable();
            $table->string('monitor_size')->nullable();
            $table->string('monitor_resolution')->nullable();
            $table->string('monitor_refresh_rate')->nullable();
            $table->text('details')->nullable();
            $table->text('specifications')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->string('image_url')->nullable();
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};