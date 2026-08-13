<?php

namespace Modules\Plan\Http\Controllers;

use App\Domains\LogerProfile\Models\LogerProfile;
use Modules\Plan\Entities\PlanTypes;
use Modules\Plan\Services\PlanService;

class ChoreController
{

    public function index(PlanService $service) {
        $user = request()->user();
        $request = request();
        // Today at-a-glance: show pending chores + those completed today, so the
        // family view keeps today's checked cards and per-member streak without
        // dragging in every chore ever finished.
        if (! $request->has('done')) {
            $request->merge(['done' => 'today']);
        }

        return inertia('Housing/Chores', [
            'chores' => [$service->getPlanType($user->current_team_id, PlanTypes::CHORES, $request)],
            // Family profiles feed the board's Owner (person) select. Naive NSelect
            // reads label/value; keep id/name too for any other consumer.
            'users' => LogerProfile::where('team_id', $user->current_team_id)
                ->get(['id', 'name'])
                ->map(fn ($p) => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'label' => $p->name,
                    'value' => $p->name,
                ])
                ->all(),
        ]);
    }

    public function store(PlanService $service) {
       $service->createPlanBoard(request()->user()->currentTeam, PlanTypes::CHORES);
    }
}
