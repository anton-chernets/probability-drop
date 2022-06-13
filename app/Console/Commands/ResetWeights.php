<?php

namespace App\Console\Commands;

use App\Models\AutoGroup;
use App\Models\Group;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class ResetWeights extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weights:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return void
     */
    public function handle(): void
    {
        AutoGroup::resetWeights();
        Artisan::call('cache:clear');
        $options = Config::get('weight.options');
        foreach ($options as $groupId => $weight) {
            Group::whereId($groupId)->update(['weight' => $weight, 'is_auto' => true]);
        }
    }
}
