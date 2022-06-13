<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GroupFactory extends Factory
{
    public function definition()
    {
        return [
            'label' => Str::random(1),
        ];
    }
}
