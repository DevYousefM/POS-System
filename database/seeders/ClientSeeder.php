<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            ["name" => "Yousef Mohamed", "national_id" => 30211172500833, "phone" => "01145119185", "address" => "Assiut"],
            ["name" => "Mahmoud Mohamed", "national_id" => 2020151545458, "phone" => "01119837931", "address" => "Egypt"],
        ];

        foreach ($clients as $item) {
            Client::create($item);
        }
    }
}
