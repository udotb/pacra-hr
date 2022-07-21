<?php

namespace App\Console\Commands;

use App\Models\jobPortal\hiringRequest;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class JobExpiryNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:expiry-notification';

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
        $expiredJobs = hiringRequest::where('lastDate', '<', Carbon::now()->format('Y-m-d'))->where('is_active', 1)->get();

        foreach ($expiredJobs as $expiredJob) {
            $expiredJob->is_active = 0;
            $expiredJob->last_updated_by = 'System';
            $expiredJob->save();
        }
        $hrmail = 'sehar.shahid@pacra.com';
//        Mail::send([], [], function ($message) use ($hrmail) {
//            $message->to($hrmail)
//                ->bcc('umair.basit@pacra.com')
//                ->subject('Jobs Expired | Career Portal')
//                ->setBody('<h3>Dear HR,</h3>
//                        <br>Jobs have been expired on Career portal. Please edit the Hiring Request and update "Job Expiry Date" if to make that Job live again.<br>
//                        <br>Thank you.<br>', 'text/html');
//            $message->from('webmaster@pacra.com', 'Webmaster PACRA');
//        });
    }
}
