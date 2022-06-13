<?php

namespace Database\Factories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerFactory extends Factory
{
    public function definition()
    {
        return [
            'display_name' => $this->faker->name(),
            'id_group' => $this->faker->randomElement(Group::pluck('id')->toArray()),
        ];
    }
}