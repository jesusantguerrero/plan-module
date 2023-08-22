<?php

namespace Modules\Plan\Services;

use Modules\Plan\Entities\PlanItem;

class PlanItemService
{
    public function getByTeamId($teamId)
    {
        return PlanItem::where("team_id", $teamId)->get();
    }
}