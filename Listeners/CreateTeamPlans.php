<?php

namespace Modules\Plan\Listeners;

use Laravel\Jetstream\Events\TeamCreated;
use Modules\Plan\Entities\PlanTypes;
use Modules\Plan\Services\PlanService;

class CreateTeamPlans
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
