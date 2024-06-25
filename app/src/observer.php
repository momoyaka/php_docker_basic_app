<?php

require_once __DIR__ . '/../vendor/autoload.php';
use Predis\Client;

$childPid = pcntl_fork();
if ($childPid) {
    echo $childPid . PHP_EOL;
    exit();
}

$sid = posix_setsid();
if ($sid < 0) {
    echo 'Error due to posix_setsid' . PHP_EOL;
    die();
}

$baseDir = dirname(__FILE__);
ini_set('error_log', $baseDir . '/error.log');

fclose(STDIN);
fclose(STDOUT);
fclose(STDERR);

$STDIN = fopen('/dev/null', 'r');
$STDOUT = fopen($baseDir.'/app.log', 'ab');
$STDERR = fopen($baseDir.'/daemon.log', 'ab');


$redis = new Client([
    'host'   => 'redis-server',
        'port'   => 6379,
]);

include 'MyWorker.php';

$worker = new \src\MyWorker($redis);
$worker->work();
