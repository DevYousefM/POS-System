<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = ["product One", "Product Two"];
        foreach ($products as $product) {

            Product::create([
                "category_id" => 1,
                "purchase_price" => 100,
                "sell_price" => 150,
                "stock" => 10,
                "image" => "products/default.png",
                "ar" => ["name" => $product, "desc" => $product . " desc"],
                "en" => ["name" => $product, "desc" => $product . " desc"],

            ]);
        }
    }
}
