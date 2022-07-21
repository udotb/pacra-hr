<?php
declare(strict_types=1);

class LogsObserver implements SplObserver
{
    public function update(SplSubject $event)
    {
        echo 'The exception message is :' . $event->log;
        // save this exception message in db or file
    }
}
