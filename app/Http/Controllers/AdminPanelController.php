<?php

namespace App\Http\Controllers;

use App\Models\AutoGroup;
use App\Models\Group;
use App\Models\SignUp;

class AdminPanelController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function groups()
    {
        $groups = Group::all()->sortByDesc('created_at');
        $autoGroups = AutoGroup::all();
        $weightSum = $autoGroups->sum('weight');
        $playersCount = SignUp::all()->count();

        return view('groups', compact('groups', 'autoGroups', 'playersCount', 'weightSum'));
    }
}