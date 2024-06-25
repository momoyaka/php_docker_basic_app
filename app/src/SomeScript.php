<?php

namespace src;
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/MyWorker.php';
use Predis\Client;
const TASK_CACHE_KEY = 't_s';
function getRedisClient(): Client
{
    return new Client([
        'host'   => 'redis-server',
        'port'   => 6379,
    ]);
}

function getWorkerToWork()
{
    $redis = getRedisClient();

    if ($redis->exists(TASK_CACHE_KEY)) {
        echo "Worker busy..." . PHP_EOL;
        return;
    }

    $lockAcquired = $redis->set(TASK_CACHE_KEY, 1, 'NX', 'EX' , 60);

    if (!$lockAcquired) {
        echo "Script is already running or recently executed. Exiting..." . PHP_EOL;
        return;
    }

    echo 'working! ' . PHP_EOL;
}
