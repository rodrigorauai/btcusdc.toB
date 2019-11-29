<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Http\Controllers\ConversorController;

class ConversorMinute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'conversor:currency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert Currency of Coinbase PRO Wallets';

    protected $conversorController;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $conversorController = new ConversorController();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $conversorController = new ConversorController();
        $dt = Carbon::now();
        do {
            $this->info('Demo:Cron Cummand Run successfully!');
            echo "Conversor Running\n";
            $conversorController->conversor();
            echo "Conversor Done\n";
            // time_sleep_until($dt->addSeconds(10)->timestamp);
            sleep(10);
            continue;
        } while(true);
    }
}
