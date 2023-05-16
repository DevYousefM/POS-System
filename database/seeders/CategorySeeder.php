<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [["ar" => "القسم الأول", "en" => "Category One"], ["ar" => "القسم الثاني", "en" => "Category Two"]];
        function createCategory($nameAr, $nameEn)
        {
            $data = [];

            $data["ar"]["name"] = "$nameAr";
            $data["en"]["name"] = "$nameEn";
            Category::create($data);
        }

        foreach ($categories as $item) {
            createCategory($item["ar"], $item["en"]);
        }

    }
}
