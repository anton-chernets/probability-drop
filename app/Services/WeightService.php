<?php

namespace App\Services;

use App\Models\AutoGroup;
use App\Models\Weight;
use Illuminate\Support\Facades\Config;

class WeightService
{
    public $options;
    public Weight $weight;

    public function __construct(Weight $weight)
    {
        $this->options = Config::get('weight.options');
        $this->weight = $weight;
    }

    public function availableWeightValue(): ?int
    {
        $arrWeights = json_decode($this->weight->values);
        if (count($arrWeights)) {
            foreach ($arrWeights as $weight) {
                if (AutoGroup::whereWeight($weight)->exists()) {
                    continue;
                }
                return $weight;
            }
        }
        return null;
    }

    public function valuesCount()
    {
        return count(json_decode($this->weight->values));
    }
}