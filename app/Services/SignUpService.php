<?php

namespace App\Services;

use App\Models\AutoGroup;
use App\Models\Player;
use App\Models\SignUp;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SignUpService
{
    protected Collection $groups;

    public const SIGN_UP_COEFFICIENT = 10;

    public function __construct()
    {
        $this->groups = AutoGroup::all();
    }

    public function groupAutoAssignee(Player $player): bool
    {
        if ($this->groups->isNotEmpty()) {
            if ($this->maxSignUpCount() <= SignUp::currentCount()) {
                SignUp::resetState();
            }
            $this->setChances();
            $chances = FileService::getFromFile();
            $groupId = searchValInAssocArr($chances, random_int(1, $chances['total']));
            $group = $this->groups->firstOrFail('id', $groupId);
            try {
                DB::beginTransaction();
                SignUp::create([
                    'player_id' => $player->id,
                    'group_id' => $group->id,
                ]);
                $player->update(['id_group' => $group->id]);
                DB::commit();
                unset($chances[$group->id][0]);
                FileService::saveToFile($chances);
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
        return $this->groups->sum('weight') * self::SIGN_UP_COEFFICIENT;
    }

    private function setChances(): void
    {
        $weightValues = $this->groups->pluck('weight','id');
        $counter = 0;
        $chances = [];
        if (count($weightValues)) {
            foreach ($weightValues as $key => $val) {
                if (!is_int($val) || $val < 1) {
                    continue;
                } elseif ($val === 1) {
                    $counter++;
                    $chances[$key][] = $counter;
                } else {
                    $j = 0;
                    while ($j <= $val):
                        $counter++;
                        $chances[$key][] = $counter;
                        $j++;
                    endwhile;
                }
            }
        }
        $chances['total'] = $counter;
        $chances['iterate'] = $this->getIterate();
        FileService::saveToFile($chances);
    }

    private function getIterate(): int
    {
        $currentState = FileService::getFromFile();
        if ($currentState && isset($currentState['iterate']) && is_numeric($currentState['iterate']))
        {
            $lastIterate = $currentState['iterate'];
            if ($lastIterate < $this->groups->sum('weight')) {
                return $lastIterate++;
            }
        }
        return 1;
    }
}