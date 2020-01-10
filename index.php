<?php

require_once 'vendor/autoload.php';

use taskforce\models\task\Task;

$task = new Task('customer', 'status_new');

print_r(assert($task->getNextStatus('action_new') == Task::STATUS_FAILED, 'action_new'));
