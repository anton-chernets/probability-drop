<?php

namespace App\Observers;

use App\Models\AutoGroup;
use App\Models\Group;
use App\Models\Weight;
use App\Services\WeightService;

class GroupObserver
{
    /**
     * Handle the player "created" event.
     *
     * @param Group $group
     * @return void
     */
    public function created(Group $group)
    {
        if ($activeWeight = Weight::getActiveWeight()) {
            $weightService = new WeightService($activeWeight);
            if (AutoGroup::all()->count() < $weightService->valuesCount()) {
                $weightValue = $weightService->availableWeightValue();
                $group->update(['is_auto' => true, 'weight' => $weightValue]);
            }
        }
    }
}