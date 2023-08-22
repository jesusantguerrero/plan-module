<?php

namespace Modules\Plan\Services;

use App\Models\Team;
use Modules\Plan\Entities\Plan;
use Modules\Plan\Entities\PlanTypes;
use Modules\Plan\Http\Resources\PlanItemResource;

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

   public function getPlanType($teamId, PlanTypes $planType, $filters)
    {
        $plan = Plan::where([
            'team_id' => $teamId,
            'plan_type_name' => $planType
        ])->first();
        return [
            'id' => $plan->id,
            'name' => $plan->name,
            'fields' => $plan->fields,
            'labels' => $plan->labels,
            'stages' => $plan->stages->map(function ($stage) use($filters) {
                return [
                    'id' => $stage->id,
                    'board_id' => $stage->board_id,
                    'name' => $stage->name,
                    'items' => PlanItemResource::collection($stage->items()
                        ->filter($filters->only('search', 'done'))
                        ->orderByField($filters->only('sort'))
                        ->get())->values()
                ];
        })];
    }
}
