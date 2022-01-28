<?php

namespace App\Http\Resources\Player;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreateResource extends JsonResource
{
    /* @var Player $resource */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
        ];
    }
}

/**
 * @OA\Schema (
 *     schema="CreatePlayerResource",
 *     type="object",
 *     title="Create Player Resource",
 *     properties={
 *         @OA\Property(property="id", type="integer"),
 *      }
 * )
 */