<?php

namespace App\Services;

use App\Exceptions\SignUpException;
use App\Models\AutoGroup;
use App\Models\Player;
use App\Models\SignUp;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SignUpService
{
    protected Collection $groups;

    public const SIGN_UP_COEFFICIENT = 10;
    public const DEFAULT_ITERATE = 1;
    public const CACHE_KEY_ITERATE = 'iterate';
    public const CACHE_KEY_POINTS = 'points';

    public function __construct()
    {
        $this->groups = AutoGroup::all();
    }

    public function groupAutoAssignee(Player $player): bool
    {
        if ($this->groups->isNotEmpty()) {
            if ($this->maxSignUpCount() <= SignUp::currentCount()) {
                SignUp::resetState();
                $this->resetCache();
            }
            if (!$this->validateCachePoints()) {
                $this->setCachePoints($this->getArrayGroupWeights());
            }
            if ($this->getIterate() > $this->groups->sum('weight')){
                $this->resetCache();
            }

            /* @var AutoGroup $group */
            $group = $this->groups->firstOrFail('id', $this->checkResult());

            try {
                DB::beginTransaction();
                SignUp::create([
                    'player_id' => $player->id,
                    'group_id' => $group->id,
                ]);
                $player->update(['id_group' => $group->id]);
                $this->nextStepToCache($group->id);
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
        return $this->groups->sum('weight') * self::SIGN_UP_COEFFICIENT;
    }

    private function checkResult(): int
    {
        if ($points = $this->getCachePoints()) {
            if (count($points)) {
                $counter = 0;
                $chances = [];
                foreach ($points as $key => $val) {
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
            } else {
                $this->resetCache();
                $this->checkResult();
            }
            return searchValInAssocArr($chances, random_int(1, $counter));
        }
        new SignUpException('undefined cache points');
    }

    private function nextStepToCache($groupId): void
    {
        try {
            $this->incrementIterate();
            $points = $this->getCachePoints();
            $point = $points[$groupId];
            $points[$groupId] = --$point;
            $this->setCachePoints($points);
        } catch (\Exception $exception) {
            new SignUpException("can't decrement point for group # " . $groupId);
        }
    }

    private function getIterate(): int
    {
        return Cache::get(self::CACHE_KEY_ITERATE, self::DEFAULT_ITERATE);
    }

    private function incrementIterate(): void
    {
        $currentIterate = $this->getIterate();
        Cache::put(self::CACHE_KEY_ITERATE, ++$currentIterate);
    }

    private function resetCache(): void
    {
        $this->setCachePoints($this->getArrayGroupWeights());
        Cache::put(self::CACHE_KEY_ITERATE, self::DEFAULT_ITERATE);
        Cache::put(self::CACHE_KEY_POINTS, $this->getArrayGroupWeights());
    }

    private function validateCachePoints(): bool
    {
        $points = $this->getCachePoints();
        foreach ($this->getArrayGroupWeights() as $key => $val) {
            if (array_key_exists($key, $points)) {
                continue;
            }
            return false;
        }
        return true;
    }

    private function setCachePoints(array $points): void
    {
        Cache::put(self::CACHE_KEY_POINTS, $points);
    }

    private function getCachePoints(): array
    {
        return (array) Cache::get(self::CACHE_KEY_POINTS);
    }

    private function getArrayGroupWeights()
    {
        return $this->groups->pluck('weight','id')->toArray();
    }
}