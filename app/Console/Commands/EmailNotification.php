<?php

namespace App\Console\Commands;


use App\Modules\Apps\Models\Templates;
use App\Modules\Project\Models\Billings;
use App\Modules\Project\Models\Milestones;
use App\Modules\Project\Models\ProjectNotifyInfoHistory;
use App\Modules\Project\Models\Tasks;
use App\Modules\Settings\Models\Configuration;
use App\Models\EmailQueue;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class EmailNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function dumpVar($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        try {

        


        } catch (Exception $e) {
            dd($e->getMessage() . ' - ' . $e->getLine());
        }
    }

    
}
