<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expense_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("expense_id")->unsigned();
            $table->string("locale")->index();
            $table->string("reason");
            $table->unique(["expense_id", "locale"]);
            $table->foreign("expense_id")->references("id")->on("expenses")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_translations');
    }
};
