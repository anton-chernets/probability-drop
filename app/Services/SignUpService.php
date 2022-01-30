<?php

namespace App\Services;

use App\Models\AutoGroup;
use App\Models\Group;
use App\Models\Player;
use App\Models\SignUp;
use App\Models\Weight;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SignUpService
{
    protected Collection $groups;
    protected ?Weight $activeWeight;

    public function __construct()
    {
        $this->groups = AutoGroup::all();
        $this->activeWeight = Weight::getActiveWeight();
    }

    public function groupAutoAssignee(Player $player): bool
    {
        if ($this->groups->isNotEmpty() && $this->activeWeight) {
            if ($this->maxSignUpCount() <= $this->signUpCount()) {
                $this->resetState();
            }
            $group = $this->groupByWeightSelectAlgo();
            try {
                DB::beginTransaction();
                SignUp::create([
                    'player_id' => $player->id,
                    'group_id' => $group->id,
                ]);
                $player->update(['id_group' => $group->id]);
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollback();
                throw $exception;
            }
            return true;
        }
        return false;
    }

    public function signUpCount(): int
    {
        return SignUp::all()->count();
    }

    public function maxSignUpCount(): int
    {
        return $this->groups->sum('weight') * Weight::SIGN_UP_COEFFICIENT;
    }

    private function groupByWeightSelectAlgo(): Group
    {
        return $this->groups->first();//TODO group selection algorithm
    }

    private function resetState(): void
    {
        SignUp::whereIn('id',SignUp::all()->pluck('id'))->delete();
    }
}