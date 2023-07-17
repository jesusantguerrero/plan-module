<?php

namespace Modules\Plan\Console;

use App\Models\Team;
use Illuminate\Console\Command;
use Modules\Plan\Entities\PlanTypes;
use Modules\Plan\Services\PlanService;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateTeamPlans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'create-team-plans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $args = $this->getArguments();
        $team = Team::find($args["team"]);
        $planService = new PlanService();

        foreach (PlanTypes::cases() as $planType) {
            $planService->createPlanBoard($team, $planType, $planType->name);
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['team', InputArgument::REQUIRED, 'Team to create plans for.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
