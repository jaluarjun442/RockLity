<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\admin\QuestionController;
use Illuminate\Support\Facades\Log;

class KeywordSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'keyword:search';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search Question With Random Keyword';

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
     * @return int
     */
    public function handle()
    {
       QuestionController::searchQuestion();
    //    QuestionController::createSitemap();
    }
}
