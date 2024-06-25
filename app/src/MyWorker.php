<?php

namespace src;
class MyWorker {
    const TASK_CACHE_KEY = 't_s';

    protected $redis;

    public function __construct($redis) {
        $this->redis = $redis;
    }

    public function work() {
        while (true) {
            if ($this->redis->exists(self::TASK_CACHE_KEY)) {
                echo 'working! ' . PHP_EOL;
                $this->timedScript();
                $this->redis->del(self::TASK_CACHE_KEY);
            }
        }
    }

    private function timedScript(): void
    {
        $startTS = time();
        sleep(5);
        $endTS = time();

        echo ($endTS - $startTS) . PHP_EOL;
    }
}
