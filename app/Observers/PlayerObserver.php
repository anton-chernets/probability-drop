<?php

namespace App\Observers;

use App\Models\Player;
use App\Services\SignUpService;

class PlayerObserver
{
    /**
     * Handle the player "created" event.
     *
     * @param Player $player
     * @return void
     */
    public function created(Player $player)
    {
        $result = app()->make(SignUpService::class)->groupAutoAssignee($player);

        logs()->debug('player created res=' . $result, $player->only('id','id_group'));
    }
}