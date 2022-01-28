<?php

namespace App\Services;

use App\Models\Group;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AutoGroupService
{
    protected Collection $groups;

    public function __construct()
    {
        //TODO in future could implement repository pattern
        $this->groups = Group::whereIsAuto(true)->get();
    }

    public function groupAutoAssignee($player): bool
    {
        if ($this->groups->isNotEmpty()) {
            if ($this->maxWeightsWeight() <= $this->sumWeightGroups()) {
                $this->clearAttaching();
            }
            $player->groups()->attach($group = $this->groupSelection(), [
                'group_id' => $group->id,
            ]);
            return true;
        }
        return false;
    }

    private function groupSelection(): Group
    {
        return $this->groups->first();
    }

    private function sumWeightGroups(): int
    {
        return 99;
    }

    private function maxWeightsWeight(): int
    {
        return 100;
    }

    private function clearAttaching(): void
    {
        DB::table('player_to_group')->delete();
    }
}