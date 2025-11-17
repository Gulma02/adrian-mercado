<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->string('seller_name');
            $table->text('description');
            $table->decimal('initial_price', 12, 2);
            $table->timestamp('scheduled_at');
            //$table->timestamp("end_at");
            $table->timestamps();

            $table->index('scheduled_at');
        });
    }

    public function down(): void {
        Schema::dropIfExists('auctions');
    }
};
