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
        return $plan;
   }

   public function getPlanType($teamId, PlanTypes $planType, $filters)
    {
        $plan = Plan::where([
            'team_id' => $teamId,
            'plan_type_name' => $planType
        ])->first();

        if (!$plan) return null;

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

    public function getPlanById($planId, $filters)
    {
        $plan = Plan::where([
            'id' => $planId,
        ])->first();

        if (!$plan) return null;

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

    public function listCustomBoards($teamId)
    {
        $plans = Plan::where([
            'team_id' => $teamId,
        ])
        ->whereNotIn('plan_type_name', [PlanTypes::CHORES, PlanTypes::EQUIPMENTS, PlanTypes::PLANS])
        ->get();


        

        return $plans->map(function ($board) {
            return [
                'id' => $board->id,
                'name' => $board->name,
                'color' => $board->color,
                'description' => $board->description,
                'template'=> $board->boardTemplate,
            ];
        });
    }

   public function getPlanTypeModel($teamId, PlanTypes $planType)
    {
        $plan = Plan::where([
            'team_id' => $teamId,
            'plan_type_name' => $planType
        ])->first();

        return $plan;
    }

    
    public function findOrCreateBySlug(Team $team, string $planTypeName, PlanTypes $type = null) {

        $plan = Plan::where([
            'team_id' => $team->id,
            'name' => $planTypeName
        ])->first();

        if (!$plan) {
            $plan = new Plan();
            $plan->user_id =  $team->user_id;
            $plan->team_id = $team->id;
            $plan->plan_type_name = $type ?? "custom";
            $plan->name = $planTypeName ?? $type->name;
            $plan->save();
            $plan->createMainStage();
        }

        return $plan;
   }
}
