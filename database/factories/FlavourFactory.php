<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FlavourFactory extends Factory
{
    protected $flavors = [
        'Chocolate',
        'Vanilla',
        'Strawberry',
        'Coffee',
        'Mint',
        'Caramel',
        'Banana',
        'Orange',
        'Lemon',
        'Green Tea'
    ];

    public function definition(): array
    {
        static $index = 0;
        $name = $this->flavors[$index++ % count($this->flavors)];

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}