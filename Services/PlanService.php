<?php

namespace Modules\Plan\Services;

use App\Models\Team;
use Modules\Plan\Entities\Plan;
use Modules\Plan\Entities\PlanTypes;

class PlanService
{
   public function createPlanBoard(Team $team, PlanTypes $type,  $planTypeName = null) {
        $plan = new Plan();
        $plan->user_id =  $team->user_id;
        $plan->team_id = $team->id;
        $plan->plan_type_name = $type;
        $plan->name = $planTypeName ?? $type->name;
        $plan->save();
        $plan->createMainStage();
   }
}
