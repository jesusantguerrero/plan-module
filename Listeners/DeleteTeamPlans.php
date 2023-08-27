<?php

namespace Modules\Plan\Listeners;

use Laravel\Jetstream\Events\TeamDeleted;
use Modules\Plan\Entities\Field;
use Modules\Plan\Entities\FieldRule;
use Modules\Plan\Entities\FieldValue;
use Modules\Plan\Entities\Plan;
use Modules\Plan\Entities\PlanChecklist;
use Modules\Plan\Entities\PlanItem;
use Modules\Plan\Entities\PlanStage;
use Modules\Plan\Entities\PlanTemplate;
use Modules\Plan\Entities\PlanType;

class DeleteTeamPlans
{

    public function handle(TeamDeleted $event)
    {
        $team = $event->team;
        Field::where("team_id", $team->id)->delete();
        FieldRule::where("team_id", $team->id)->delete();
        FieldValue::where("team_id", $team->id)->delete();
        PlanChecklist::where("team_id", $team->id)->delete();
        PlanItem::where("team_id", $team->id)->delete();
        PlanStage::where("team_id", $team->id)->delete();
        PlanTemplate::where("team_id", $team->id)->delete();
        PlanType::where("team_id", $team->id)->delete();
        Plan::where("team_id", $team->id)->delete();
    }
}
