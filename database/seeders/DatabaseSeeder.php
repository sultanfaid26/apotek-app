<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
          User::create([
               "name" => "Administrator",
               "email" => "admin@gmail.com",
               "password" => Hash::make("adminapotek"),
               "role" => "admin",
          ]);
       User::create([
            "name" => "Kasir Apotek",
            "email" => "Kasir@gmail.com",
            "password" => Hash::make("kasirapotek"),
            "role" => "kasir",
       ]);
    }
}
