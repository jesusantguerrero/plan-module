<?php

namespace Modules\Plan\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Jetstream\Events\TeamCreated;
use Modules\Plan\Entities\PlanTypes;
use Modules\Plan\Services\PlanService;

class CreateTeamBoards
{

    public function handle(TeamCreated $event)
    {
        $team = $event->team;
        $planService = new PlanService();
        foreach (PlanTypes::cases() as $planType) {
            $planService->createPlanBoard($team, $planType, $planType->name);
        }
    }
}
