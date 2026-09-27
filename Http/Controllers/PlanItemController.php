<?php

namespace Modules\Plan\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Item as ResourcesItem;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use Modules\Plan\Entities\Plan;
use Modules\Plan\Entities\PlanItem;
use Modules\Plan\Http\Resources\PlanItemResource;
use Modules\Plan\Http\Services\PlanItemService;

class PlanItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PlanItemService $itemService)
    {
        return $itemService->getByTeamId(request()->user()->current_team_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Response $response, Plan $plan)
    {
        $this->ensureTeamPlan($plan);
        $postData = $request->post();
        $this->ensureStageOfPlan($plan, $postData['stage_id'] ?? null);
        $item = new PlanItem();
        // Only mass-assign real columns: the payload also carries `fields`,
        // `checklist`, `board_id` and flattened field values (owner/status/...),
        // none of which are columns. Under Model::preventSilentlyDiscardingAttributes
        // (on outside production) passing them to create() throws.
        $item = $item::create(array_merge(Arr::only($postData, $item->getFillable()), [
            "plan_id" => $plan->id,
            "user_id" => $request->user()->id,
            "team_id" => $request->user()->current_team_id,
        ]));
        $item->saveFields($request->post('fields'));
        $item->saveCheckList($request->post('checklist'));
        return $item;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $planId, PlanItem $item)
    {
        $this->ensureItemOfPlan($planId, $item);
        $data = Arr::except(Arr::only($request->post(), $item->getFillable()), ['plan_id', 'team_id', 'user_id']);
        $this->ensureStageOfPlan(Plan::find($item->plan_id), $data['stage_id'] ?? null);
        if ($request->filled('recurrence')) {
            $data['rrule'] = PlanItem::rruleForPreset($request->input('recurrence'), $item->rrule);
        }
        $item->update($data);
        $item->saveFields($request->post('fields'));
        $item->saveCheckList($request->post('checklist'));
        return $item;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($planId, PlanItem $item)
    {
        $this->ensureItemOfPlan($planId, $item);
        $item->delete();
        return $item;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete(Request $request)
    {
        $items = $request->post();
        PlanItem::where('team_id', $request->user()->current_team_id)->whereIn('id', $items)->delete();
        return $items;
    }

    private function ensureTeamPlan(Plan $plan): void
    {
        abort_unless((int) $plan->team_id === (int) request()->user()->current_team_id, 404);
    }

    private function ensureItemOfPlan($planId, PlanItem $item): void
    {
        abort_unless(
            (int) $item->plan_id === (int) $planId
                && (int) $item->team_id === (int) request()->user()->current_team_id,
            404
        );
    }

    private function ensureStageOfPlan(?Plan $plan, $stageId): void
    {
        if (! $stageId) {
            return;
        }

        abort_unless($plan && $plan->stages()->whereKey($stageId)->exists(), 422, 'The stage does not belong to this plan.');
    }

    public function getTodo(Request $request) {
        return PlanItemResource::collection(PlanItem::getByCustomField(['status', 'todo'], $request->user()));
    }
}