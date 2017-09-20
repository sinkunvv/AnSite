<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\RssController AS RC;

class RssUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Rss Feeds';

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
        RC::update();
    }
}
