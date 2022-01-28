<?php

namespace App\Services;

use App\Models\Group;
use App\Models\Player;
use Illuminate\Database\Eloquent\Collection;

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
            if ($this->maxWeightSum() <= $this->weightSum()) {
                $this->clearAssigning();
            }
            $player->update(['id_group' => $this->groupSelection()->id]);
            return true;
        }
        return false;
    }

    private function groupSelection(): Group
    {
        return $this->groups->first();//TODO Weight algorithm
    }

    public function weightSum(): int
    {
        $result = 0;
        foreach ($this->groups as $group) {
            $result += $group->total_players;
        }
        return $result;
    }

    private function maxWeightSum(): int
    {
        return $this->groups->sum('weight');
    }

    private function clearAssigning(): void
    {
        $players = Player::where('id_group', '!=', 0);
        $players->update(['id_group' => 0]);
    }
}