<?php

namespace Modules\Plan\Listeners;

use Laravel\Jetstream\Events\TeamCreated;
use Modules\Plan\Entities\PlanTypes;
use Modules\Plan\Services\PlanService;

class CreateTeamPlans
{

    public function handle(TeamCreated $event)
    {
        if (! config('plan.create_team_plans', true)) {
            return;
        }

        $team = $event->team;
        $planService = new PlanService();
        foreach (PlanTypes::cases() as $planType) {
            if ($planType === PlanTypes::PROJECT) {
                continue; // projects are created on demand, one board each
            }

            $planService->createPlanBoard($team, $planType, $planType->name);
        }
    }
}
