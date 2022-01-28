<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlayerRequest;
use App\Http\Resources\Group\AssignedResource;
use App\Http\Resources\Player\CreateResource;
use App\Models\Player;

class PlayerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/create",
     *     summary="Create player",
     *     description="Create player of the resource.",
     *     tags={"Players"},
     *     @OA\RequestBody(
     *         description="Create player request",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreatePlayerRequest")
     *     ),
     *     @OA\Response(
     *        response="200",
     *        description="Successful response",
     *        @OA\JsonContent(
     *          @OA\Property(
     *              property="data",
     *              type="array",
     *              @OA\Items(
     *                  type="object",
     *                  format="query",
     *                  @OA\Property(property="result", type="string", example="ok"),
     *                  @OA\Property(property="player", type="array", @OA\Items(ref="#/components/schemas/CreatePlayerResource")),
     *                  @OA\Property(property="group", type="array", @OA\Items(ref="#/components/schemas/AssignedGroupResource")),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *         response=422,
     *         description="Error response",
     *         @OA\JsonContent(
     *             @OA\Property(property="result", type="string", example="error"),
     *             @OA\Property(property="code", type="integer", example=422),
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *         )
     *      )
     *   ),
     * )
     * @param CreatePlayerRequest $request
     */
    public function create(CreatePlayerRequest $request)
    {
        $validatedData = $request->validated();
        if (isset($validatedData['auto'])) {
            $player = Player::autoCreate();
        } else {
            $player = Player::create($validatedData);
        }
        return response()->json([
            'result' => 'ok',
            'player'=> CreateResource::make($player),
            'group'=> AssignedResource::make($player->groups->first()),
        ]);
    }
}