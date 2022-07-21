<?php

namespace App\Console\Commands;

use App\Models\Attendance\AttendanceModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddAbsentEmployees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:absent';

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
        $today_attendance = DB::table('og_users')
            ->select('og_users.id')
            ->where('is_active', '1')
            ->whereNotIn('og_users.id', [10, 48, 297, 298, 344])
            ->whereNotIn('og_users.id',
                function ($join) {
                    $join->select('user_id')->from('pacra_attendance')
                        ->where('pacra_attendance.date', '=', date("Y-m-d"));
                })
            ->get();

        foreach ($today_attendance as $att) {
            AttendanceModel::create(['user_id' => $att->id, 'date' => date('Y-m-d'), 'status' => 4]);
            DB::statement("UPDATE  pacra_leaves_balance SET current_balance = current_balance - 1
                 where user_id = $att->id");
        }
    }
}
