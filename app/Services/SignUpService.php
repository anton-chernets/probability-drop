<?php

namespace App\Services;

use App\Models\AutoGroup;
use App\Models\Group;
use App\Models\Player;
use App\Models\SignUp;
use App\Models\Weight;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as PluckCollection;
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
            if ($this->maxSignUpCount() <= SignUp::currentCount()) {
                SignUp::resetState();
            }
            $group = $this->algoApplyAutoGroup($this->groups->pluck('weight','id'));
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

    private function maxSignUpCount(): int
    {
        return $this->groups->sum('weight') * Weight::SIGN_UP_COEFFICIENT;
    }

    private function algoApplyAutoGroup(PluckCollection $weightValues): Group
    {
        $arrays = [];
        $counter = 0;
        if (count($weightValues)) {
            foreach ($weightValues as $key => $val) {
                if (!is_int($val) || $val < 1) {
                    continue;
                } elseif ($val === 1) {
                    $counter++;
                    $arrays[$key][] = $counter;
                } else {
                    $j = 0;
                    while ($j <= $val):
                        $counter++;
                        $arrays[$key][] = $counter;
                        $j++;
                    endwhile;
                }
            }
        }
        return $this->groups->firstOrFail('id', searchValInAssocArr($arrays, random_int(1, $counter)));
    }
}