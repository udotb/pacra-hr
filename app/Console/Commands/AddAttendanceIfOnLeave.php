<?php

namespace App\Console\Commands;

use App\Models\Attendance\AttendanceModel;
use App\Models\Leaves\pacraLeavesBalance;
use App\Models\Leaves\PacraLeavesModel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AddAttendanceIfOnLeave extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:addAttendanceIfOnLeave';

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
        $now = Carbon::now()->format('Y-m-d');
        $check = AttendanceModel::where('date', $now)->pluck('user_id')->toArray();
        $leaves = PacraLeavesModel::whereDate('from_date', '<=', $now)->whereDate('to_date', '>=', $now)
            ->where('leave_type', '!=', 8)
            ->where('status', 'Approved')
            ->whereNotIn('user_id', $check)
            ->get();

        if (!empty($leaves->first()->id)) {
            foreach ($leaves as $leave) {
                $fromDate = Carbon::parse($leave->from_date);
                $toDate = Carbon::parse($leave->to_date);
                $diff = $fromDate->diffInDays($toDate);

                AttendanceModel::updateOrCreate([
                    'user_id' => $leave->user_id,
                    'date' => date('Y-m-d'),
                ], [
                    'user_id' => $leave->user_id,
                    'date' => date('Y-m-d'),
                    'status' => 3,
                    'office_hours' => '00:00:00'
                ]);

                if ($leave->leave_type == 7 && $diff > 3) {
                    $leaveBalance = pacraLeavesBalance::where('user_id', $leave->user_id)->first();
                    $leaveBalance->current_balance = $leaveBalance->current_balance - 1;
                    $leaveBalance->update();
                } else if ($leave->leave_type == 6 && $diff > 90) {
                    $leaveBalance = pacraLeavesBalance::where('user_id', $leave->user_id)->first();
                    $leaveBalance->current_balance = $leaveBalance->current_balance - 1;
                    $leaveBalance->update();
                } else if ($leave->leave_type == 9) {
                    $leaveBalance = pacraLeavesBalance::where('user_id', $leave->user_id)->first();
                    $leaveBalance->current_balance = $leaveBalance->current_balance - 0.5;
                    $leaveBalance->update();
                } else if ($leave->leave_type == 1 || $leave->leave_type == 2 || $leave->leave_type == 3 || $leave->leave_type == 4 || $leave->leave_type == 5) {
                    $leaveBalance = pacraLeavesBalance::where('user_id', $leave->user_id)->first();
                    $leaveBalance->current_balance = $leaveBalance->current_balance - 1;
                    $leaveBalance->update();
                }
            }
        }
    }
}
