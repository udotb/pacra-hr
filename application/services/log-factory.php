<?php
declare(strict_types=1);

namespace Application\Services;

class LogFactory
{

    public function __construct(string $log)
    {
        $log = new \Logs($log);
        $log->attach(new \LogsObserver());
        $log->notify();
    }
}
