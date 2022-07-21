<?php

namespace App\Console\Commands;

use App\Helpers\helpers;
use App\Models\attendance\AttendanceEditRequest;
use App\Models\Leaves\PacraLeavesModel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ApprovalReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'approval:reminder';

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
        $upto = Carbon::now()->subDays(15)->format('Y-m-d');
        $unApprovedLeaves = PacraLeavesModel::where('status', 'Recommend')->where('to_date', '>=', $upto)->get();
        $unApprovedEditAttendance = AttendanceEditRequest::where('status', 'Recommended')->get();

        foreach ($unApprovedLeaves as $unApprovedLeave) {
            $hrmail = helpers::hrEmail($unApprovedLeave->user_id);
            $teamleademail = helpers::get_teamlead_email($unApprovedLeave->user_id);
            $username = helpers::get_userName($unApprovedLeave->user_id);
            $usermail = helpers::get_userEmail($unApprovedLeave->user_id);

            if ($unApprovedLeave) {
                Mail::send([], [], function ($message) use ($hrmail, $teamleademail, $usermail, $username) {
                    $message->to($teamleademail)
                        ->cc($usermail)
                        ->subject($username . ' Leave Approval Reminder')
                        ->setBody('<h3>Dear Team Lead</h3>
                        <br>Please Approve Pending Leave Requests of' . $username . ' before 20th Of this Month.<br>
                        <br>Thank you.<br>', 'text/html');
                    $message->from('webmaster@pacra.com', 'Webmaster PACRA');
                });
            }
        }

        foreach ($unApprovedEditAttendance as $unApprovedEditAtt) {
            $hrmail = helpers::hrEmail($unApprovedEditAtt->user_id);
            $teamleademail = helpers::get_teamlead_email($unApprovedEditAtt->user_id);
            $username = helpers::get_userName($unApprovedEditAtt->user_id);
            $usermail = helpers::get_userEmail($unApprovedEditAtt->user_id);

            if ($unApprovedEditAtt) {
                Mail::send([], [], function ($message) use ($hrmail, $teamleademail, $usermail, $username) {
                    $message->to($teamleademail)
                        ->cc($usermail)
                        ->subject($username . ' Leave Approval Reminder')
                        ->setBody('<h3>Dear Team Lead</h3>
                        <br>Please Approve Pending Edit Attendance Requests of' . $username . ' before 20th Of this Month.<br>
                        <br>Thank you.<br>', 'text/html');
                    $message->from('webmaster@pacra.com', 'Webmaster PACRA');
                });
            }
        }
    }

}
