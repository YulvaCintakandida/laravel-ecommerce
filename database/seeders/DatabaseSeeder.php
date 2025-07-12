<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'seller',
            'phone' => '1234567890',
            'address' => '123 Admin Street, Admin City, Admin Country',
        ]);

        // Customer user
        \App\Models\User::factory()->create([
            'name' => 'Customer User',
            'email' => 'customer@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'phone' => '0987654321',
            'address' => '456 Customer Avenue, Customer City, Customer Country',
        ]);

        // Create categories and flavours first
        $categories = \App\Models\Category::factory(3)->create();
        $flavours = \App\Models\Flavour::factory(10)->create();

        // Create products with random existing categories and flavours
        foreach(range(1, 10) as $index) {
            \App\Models\Product::factory()->create([
                'category_id' => $categories->random()->id,
                'flavour_id' => $flavours->random()->id,
            ]);
        }
    }
}