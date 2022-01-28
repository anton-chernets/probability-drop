<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0",
     *      title="WoodenSword v3",
     *      description="Api for base logic test task for skills Laravel, MySQL, algorithms.",
     *      @OA\License(
     *         name="Anton Chernets",
     *      ),
     *  ),
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
