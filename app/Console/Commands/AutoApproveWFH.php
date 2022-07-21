<?php

namespace App\Console\Commands;

use App\Helpers\helpers;
use App\Models\attendance\WorkFromHomeModel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class AutoApproveWFH extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:wfh';

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
        $recommendedWFH = WorkFromHomeModel::where('status', 'Recommend')->get();
        foreach ($recommendedWFH as $recWFH) {
            if ($recWFH->updated_at < Carbon::createFromTime(18)) {
                $hrmail = helpers::hrEmail($recWFH->user_id);
                $teamleademail = helpers::get_teamlead_email($recWFH->user_id);
                $username = helpers::get_userName($recWFH->user_id);
                $usermail = helpers::get_userEmail($recWFH->user_id);

                if ($recWFH) {
                    WorkFromHomeModel::updateOrCreate([
                        'id' => $recWFH->id,
                    ], [
                        'status' => 'Approve',
                        'approved_by' => 'system approval',
                    ]);

                    Mail::send([], [], function ($message) use ($hrmail, $teamleademail, $usermail, $username) {
                        $message->to($hrmail)
                            ->cc($teamleademail)
                            ->subject($username . ' WFH Auto Approved')
                            ->setBody('<h3>Dear HR</h3>
                        <br>System has Auto Approved WFH of' . $username . ' successfully.<br>
                        <br>Thank you.<br>', 'text/html');
                        $message->from('webmaster@pacra.com', 'Webmaster PACRA');
                    });

                    Mail::send([], [], function ($message) use ($hrmail, $teamleademail, $usermail, $username) {
                        $message->to($usermail)
                            ->subject('WFH Auto Approved')
                            ->setBody('<h3>Dear ' . $username . '</h3>
                        <br>System has Auto Approved your WFH application successfully.<br>
                        <br>Thank you.<br>', 'text/html');
                        $message->from('webmaster@pacra.com', 'Webmaster PACRA');
                    });
                }
            }
        }
    }
}
