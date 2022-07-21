<?php

namespace App\Console\Commands;

use App\Models\Attendance\AttendanceModel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PunchOut extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'punch:out';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Punch Out of 3PM if Punch out is NULL in flexible timings';

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
        $today = Carbon::now()->format('Y-m-d');
        $pacraAttendance = AttendanceModel::where('date', $today)->whereIn('status', [1, 2])->whereNull('log_out_time')->get();
//        if (Carbon::today()->dayName == 'Friday') {
//            foreach ($pacraAttendance as $attendance) {
//                $punchOut = Carbon::createFromFormat('H:s:i', '12:00:00');
//                $punchIn = Carbon::createFromFormat('H:s:i', $attendance->log_in_time);
//                $diff_in_hours = $punchOut->diffInSeconds($punchIn);
//                $diff_in_hours = gmdate('H:i:s', $diff_in_hours);
//
//                if ($attendance->log_out_time == null) {
//                    AttendanceModel::updateOrCreate([
//                        'id' => $attendance->id,
//                        'user_id' => $attendance->user_id
//                    ],
//                        [
//                            'log_out_time' => '12:00:00',
//                            'punch_out_status' => 'Auto Punch Out',
//                            'office_hours' => $diff_in_hours,
//                        ]);
//                }
//            }
//        } else {
        foreach ($pacraAttendance as $attendance) {
            $punchOut = Carbon::createFromFormat('H:s:i', '17:00:00');
            $punchIn = Carbon::createFromFormat('H:s:i', $attendance->log_in_time);
            $diff_in_hours = $punchOut->diffInSeconds($punchIn);
            $diff_in_hours = gmdate('H:i:s', $diff_in_hours);

            if ($attendance->log_out_time == null) {
                AttendanceModel::updateOrCreate([
                    'id' => $attendance->id,
                    'user_id' => $attendance->user_id
                ],
                    [
                        'log_out_time' => '17:00:00',
                        'punch_out_status' => 'Auto Punch Out',
                        'office_hours' => $diff_in_hours,
                    ]);
            }
        }
//        }
    }
}
