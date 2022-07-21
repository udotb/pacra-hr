<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
Use Illuminate\Support\Facades\Mail;

class testmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:testMail';

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
        Mail::send([], [], function ($message) {
            $message->to('muhammad.saqib@pacra.com')
    ->subject('Test Schedule')
    // here comes what you want
    ->setBody('Hi, welcome user!'); // assuming text/plain
});
    }
}
