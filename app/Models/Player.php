<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Player
 *
 * @property int $id
 * @property string|null $display_name
 * @property int $id_group
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Group[] $groups
 * @property-read int|null $groups_count
 * @method static \Database\Factories\PlayerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Player newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Player newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Player query()
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereIdGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Player whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Player extends Model
{
    use HasFactory;

    private const DISPLAY_NAME_PREFIX = 'Player #';

    protected $fillable = [
        'display_name',
        'id_group',
    ];

    public static function autoCreate(): self
    {
        /* @var self $player */
        $player = self::create();
        $player->update(['display_name' => self::DISPLAY_NAME_PREFIX . $player->id]);
        return $player;
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(
            Group::class,
            'player_to_group',
            'player_id',
            'group_id',
        );
    }
}