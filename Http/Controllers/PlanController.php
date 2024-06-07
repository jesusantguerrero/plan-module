<?php

namespace Modules\Plan\Http\Controllers;

use Modules\Plan\Entities\PlanTypes;
use Modules\Plan\Services\PlanService;

class PlanController
{
    public function index(PlanService $service) {
        $user = request()->user();

        return inertia('Housing/Chores', [
            'chores' =>  [$service->getPlanType($user->current_team_id, PlanTypes::PLANS, request())]
        ]);
    }

    public function store(PlanService $service) {
        $service->createPlanBoard(request()->user()->currentTeam, PlanTypes::PLANS);
    }
}
