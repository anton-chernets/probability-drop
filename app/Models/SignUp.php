<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\SignUp
 *
 * @property int $id
 * @property int $player_id
 * @property int $group_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|SignUp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SignUp newQuery()
 * @method static \Illuminate\Database\Query\Builder|SignUp onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SignUp query()
 * @method static \Illuminate\Database\Eloquent\Builder|SignUp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SignUp whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SignUp whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SignUp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SignUp wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SignUp whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|SignUp withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SignUp withoutTrashed()
 * @mixin \Eloquent
 */
class SignUp extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'player_id',
        'group_id',
    ];
}