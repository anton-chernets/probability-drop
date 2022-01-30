<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Weight
 *
 * @property int $id
 * @property mixed $values
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\WeightFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Weight newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Weight newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Weight query()
 * @method static \Illuminate\Database\Eloquent\Builder|Weight whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Weight whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Weight whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Weight whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Weight whereValues($value)
 * @mixin \Eloquent
 */
class Weight extends Model
{
    use HasFactory;

    public const SIGN_UP_COEFFICIENT = 10;

    protected $fillable = [
        'values',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function getActiveWeight(): ?self//TODO in future could implement repository pattern
    {
        return self::whereIsActive(true)->first();
    }

    public function valuesCount(): int
    {
        return count(json_decode($this->values));
    }
}