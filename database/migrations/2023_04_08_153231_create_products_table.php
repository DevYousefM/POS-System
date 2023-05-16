<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("category_id")->unsigned();
            $table->string("image")->default("products/default.png");
            $table->double("purchase_price", 8, 2);
            $table->double("sell_price", 8, 2);
            $table->integer("stock");
            $table->foreign("category_id")->references("id")->on("categories")->onDelete("cascade");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
