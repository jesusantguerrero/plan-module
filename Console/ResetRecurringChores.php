<?php

namespace Modules\Plan\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Plan\Entities\PlanItem;
use Modules\Plan\Entities\PlanTypes;
use RRule\RRule;

class ResetRecurringChores extends Command
{
    protected $signature = "chores:reset-recurring";

    protected $description = "Reset completed recurring chores whose next occurrence day has arrived, so the family screen re-populates each day.";

    public function handle(): int
    {
        $today = Carbon::today();
        $reset = 0;

        PlanItem::query()
            ->where("is_done", true)
            ->whereNotNull("commit_date")
            ->whereNotNull("rrule")
            ->whereHas("stage.board", fn ($q) => $q->where("plan_type_name", PlanTypes::CHORES))
            ->chunkById(200, function ($items) use ($today, &$reset) {
                foreach ($items as $item) {
                    if ($this->shouldReset($item, $today)) {
                        $item->is_done = false;
                        $item->commit_date = null;
                        $item->save(); // boot syncs state -> pending
                        $reset++;
                    }
                }
            });

        $this->info("Reset {$reset} recurring chore(s).");

        return self::SUCCESS;
    }

    private function shouldReset(PlanItem $item, Carbon $today): bool
    {
        try {
            $rrule = new RRule($item->rrule);
        } catch (\Throwable $e) {
            return false;
        }

        $from = Carbon::parse($item->commit_date)->addDay()->startOfDay();
        if ($from->greaterThan($today)) {
            return false;
        }

        // True when an occurrence day fell between the day after completion and today.
        return count($rrule->getOccurrencesBetween($from, $today->copy()->endOfDay())) > 0;
    }
}
