<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\AutoGroup
 *
 * @property int $id
 * @property string $label
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $is_auto
 * @property int|null $weight
 * @property-read mixed $percent_total_players
 * @property-read mixed $percent_total_weight
 * @property-read mixed $total_players
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SignUp[] $signUps
 * @property-read int|null $sign_ups_count
 * @method static Builder|AutoGroup newModelQuery()
 * @method static Builder|AutoGroup newQuery()
 * @method static Builder|AutoGroup query()
 * @method static Builder|AutoGroup whereCreatedAt($value)
 * @method static Builder|AutoGroup whereId($value)
 * @method static Builder|AutoGroup whereIsAuto($value)
 * @method static Builder|AutoGroup whereLabel($value)
 * @method static Builder|AutoGroup whereUpdatedAt($value)
 * @method static Builder|AutoGroup whereWeight($value)
 * @mixin \Eloquent
 */
class AutoGroup extends Group
{
    protected $table = 'groups';

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('autogroup', function (Builder $builder) {
            $builder->whereIsAuto(true);
        });
    }

    public function signUps(): HasMany
    {
        return $this->hasMany(SignUp::class, 'group_id', 'id');
    }

    public function getTotalPlayersAttribute()
    {
        return $this->signUps->count();
    }

    public function getPercentTotalWeightAttribute()
    {
        if ($sumWeight = self::all()->sum('weight')) {
            return PERCENT_TOTAL / $sumWeight * $this->weight;
        }
        return 0;
    }

    public function getPercentTotalPlayersAttribute()
    {
        if ($countSignUps = SignUp::all()->count()) {
            return PERCENT_TOTAL / $countSignUps * $this->signUps->count();
        }
        return 0;
    }

    public static function resetWeights(): void
    {
        $ids = self::whereIsAuto(true)->orWhere('weight', '!=', null)->pluck('id');
        if ($ids->count()) {
            self::whereIn('id', $ids)->update(['weight' => null, 'is_auto' => false]);
        }
    }
}