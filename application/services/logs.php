<?php
declare(strict_types=1);

class Logs extends event
{
    public $log;

    public function __construct(string $log)
    {
        parent::__construct();
        $this->log = $log;
    }
}
