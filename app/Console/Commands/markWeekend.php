<?php

namespace App\Console\Commands;

use App\Models\Attendance\AttendanceModel;
use App\Models\Employees\UsersModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class markWeekend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mark:weekend';

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
        $today_attendance = DB::table('og_users')
            ->select('og_users.id')
            ->where('is_active', '1')
            ->whereNotIn('og_users.id', [48, 243, 297, 298, 372, 344, 10])
            ->whereNotIn('og_users.id',
                function ($join) {
                    $join->select('user_id')->from('pacra_attendance')
                        ->where('pacra_attendance.date', '=', date("Y-m-d"))
                        ->whereNotNull('pacra_attendance.status');
                })
            ->get();

        foreach ($today_attendance as $att) {
            $attendanceTable = new AttendanceModel;
            $attendanceTable->user_id = $att->id;
            $attendanceTable->date = date('Y-m-d');
            $attendanceTable->status = 5;
            $attendanceTable->save();
        }
    }
}
