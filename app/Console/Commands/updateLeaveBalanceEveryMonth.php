<?php

namespace App\Console\Commands;

use App\Models\Employees\UsersModel;
use App\Models\Leaves\pacraLeavesBalance;
use App\Models\Leaves\pacraNegativeLeavesBalance;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class updateLeaveBalanceEveryMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:leaveBalance';

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
        $users = UsersModel::select('id', 'display_name', 'doj')
            ->where('is_active', 1)
            ->get();

        $firstYear = DB::table('pacra_leave_policy')
            ->select('title', 'policy')
            ->where('title', '=', '1st Year')
            ->get();

        $secondYear = DB::table('pacra_leave_policy')
            ->select('title', 'policy')
            ->where('title', '=', '2nd Year')
            ->get();

        $negativeBalanceArray = [];
        $negativeBalance = pacraLeavesBalance::where('current_balance', '<', 0)->get();
        foreach ($negativeBalance as $balance) {
            array_push($negativeBalanceArray, ['user_id' => $balance->user_id, 'current_balance' => $balance->current_balance]);

            $negativeBalanceTable = new pacraNegativeLeavesBalance();
            $negativeBalanceTable->user_id = $balance['user_id'];
            $negativeBalanceTable->negative_balance = $balance['current_balance'];
            $negativeBalanceTable->month_year = Carbon::now();
            $negativeBalanceTable->save();
        }

        pacraLeavesBalance::where('current_balance', '<', 0)
            ->update(['current_balance' => 0]);


        foreach ($users as $user) {

            $date1 = $user->doj;
            $date2 = date("H:i:s ");
            $diff = abs(strtotime($date2) - strtotime($date1));
            $years = floor($diff / (365 * 60 * 60 * 24));
            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
            $experience = $years . '.' . $months;

            if ($experience < 2) {
                $leaves = $firstYear[0]->policy / 12;
            } else {
                $leaves = $secondYear[0]->policy / 12;
            }

            DB::statement("UPDATE  pacra_leaves_balance SET current_balance = current_balance + $leaves where user_id = $user->id");
        }
    }
}
