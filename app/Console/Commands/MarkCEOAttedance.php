<?php

namespace App\Console\Commands;

use App\Models\Attendance\AttendanceModel;
use Illuminate\Console\Command;

class MarkCEOAttedance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:ceo-attendance';

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
     * @return int
     */
    public function handle()
    {
        AttendanceModel::create(['user_id' => 10, 'date' => date('Y-m-d'),
            'log_in_time' => '09:00:00', 'ip_address_login' => '202.141.241.58', 'status' => 2]);
    }
}
