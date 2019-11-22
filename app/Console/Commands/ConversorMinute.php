<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

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
        //
        $dt = Carbon::now();
        $x = 60/5;
        do {
            echo "Começou a execução\n";
            app('App\Http\Controllers\ConversorController')->conversor();
            echo "Converted\n";
            time_sleep_until($dt->addSeconds(15)->timestamp);
        } while($x-- > 0);
    }
}
