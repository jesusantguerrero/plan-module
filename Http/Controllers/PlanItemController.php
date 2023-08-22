<?php

namespace Modules\Plan\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Item as ResourcesItem;
use Illuminate\Http\Request;
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
        $postData = $request->post();
        $item = new PlanItem();
        $item = $item::create(array_merge($postData, [
            "plan_id" => $plan->id,
            "user_id" => $request->user()->id,
            "team_id" => $request->user()->current_team_id,
        ]));
        $item->saveFields($request->post('fields'));
        $item->saveCheckList($request->post('checklist'));
        return $response->send($item);
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
    public function update(Request $request, $_planId, PlanItem $item)
    {
        $item->update($request->post());
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
        PlanItem::whereIn('id', $items)->delete();
        return $items;
    }

    public function getTodo(Request $request) {
        return PlanItemResource::collection(PlanItem::getByCustomField(['status', 'todo'], $request->user()));
    }
}