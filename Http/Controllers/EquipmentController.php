<?php

namespace Modules\Plan\Http\Controllers;

use Freesgen\Atmosphere\Http\InertiaController;
use Modules\Plan\Entities\Plan;
use Modules\Plan\Entities\PlanTypes;
use Modules\Plan\Http\Resources\PlanResource;

class EquipmentController
{
    public function index() {
        $user = request()->user();

        return inertia('Housing/Chores', [
            'chores' =>  PlanResource::collection(Plan::where([
                'team_id' => $user->current_team_id,
                'user_id' => $user->id,
                'plan_type_name' => PlanTypes::EQUIPMENTS
            ])->get()),
        ]);
    }
}
