<?php

use taskforce\models\task\Task;

require_once 'vendor/autoload.php';

$task = new Task('customer', 'status_new');

var_dump($task->getNextStatus('status_new'));
