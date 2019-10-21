<?php

namespace App\Console\Commands;

use App\Services\CalendarApi;
use Illuminate\Console\Command;

class RunCalendarApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendar:api';

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
     * @return mixed
     */
    public function handle()
    {
        $calendarApi = new CalendarApi();
        $calendarApi->getList();
    }
}
