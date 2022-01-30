<?php

namespace Database\Factories;

use App\Models\Weight;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Services\WeightService;

class WeightFactory extends Factory
{
    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JsonException
     */
    public function definition()
    {
        $options = app()->make(WeightService::class)->options[Weight::all()->count()];
        return [
            'values' => json_encode($options, JSON_THROW_ON_ERROR),
            'is_active' => Weight::get()->isNotEmpty(),
        ];
    }
}