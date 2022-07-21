<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\updateLeaveBalanceEveryMonth::class,
        Commands\AddHolidaysInAttendance::class,
        Commands\AddAttendanceIfOnLeave::class,
        Commands\AddAbsentEmployees::class,
        Commands\AutoApproveWFH::class,
        Commands\PunchOut::class,
        Commands\JobExpiryNotification::class,
        Commands\MarkWeekend::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->command('add:absent')->weekdays()->at('23:30');
        $schedule->command('punch:out')->weekdays()->at('23:55');
        $schedule->command('add:addHolidayInAttendance')->dailyAt('08:50');
        $schedule->command('add:addAttendanceIfOnLeave')->weekdays()->at('08:58');
        $schedule->command('add:addAttendanceIfOnLeave')->weekdays()->at('13:00');
        $schedule->command('job:expiry-notification')->dailyAt('10:00');
        $schedule->command('auto:wfh')->weekdays()->at('07:58');
        $schedule->command('mark:weekend')->weekends()->at('12:00');
        $schedule->command('add:leaveBalance')->monthlyOn(21, '1:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
