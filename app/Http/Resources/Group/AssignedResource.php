<?php

namespace App\Http\Resources\Group;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignedResource extends JsonResource
{
    /* @var Group $resource */
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
            'label' => $this->resource->label ?? null,
        ];
    }
}

/**
 * @OA\Schema (
 *     schema="AssignedGroupResource",
 *     type="object",
 *     title="Assigned Group when Create Player Resource",
 *     properties={
 *         @OA\Property(property="label", type="string"),
 *      }
 * )
 */
