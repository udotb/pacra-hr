<?php

namespace App\Console\Commands;

use App\Models\Attendance\AttendanceModel;
use App\Models\Employees\UsersModel;
use App\Models\holidaysModel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AddHolidaysInAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:addHolidayInAttendance';

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
        $Holiday = holidaysModel::whereDate('from_date', '<=', carbon::now())->whereDate('to_date', '>=', carbon::now())
            ->where('status', 'Approved')
            ->get();

        $users = UsersModel::select('id', 'display_name', 'doj')
            ->where('is_active', '=', 1)
            // ->whereIn('id', ['125','12'])
            ->get();

        if (!empty($Holiday->first()->id)) {
            foreach ($users as $user) {
                AttendanceModel::updateOrCreate([
                    'user_id' => $user->id,
                    'date' => date('Y-m-d'),
                ], [
                    'user_id' => $user->id,
                    'date' => date('Y-m-d'),
                    'status' => 6,
                    'office_hours' => '00:00:00'
                ]);
            }
        }
    }
}
