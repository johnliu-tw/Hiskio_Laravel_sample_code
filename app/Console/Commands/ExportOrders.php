<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;

class ExportOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exports:orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '...brabrabra';

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
        $today = today()->toDateString();
        Excel::store(new OrdersExport, 'excels/'.$today.' 訂單清單.xlsx');
    }
}
