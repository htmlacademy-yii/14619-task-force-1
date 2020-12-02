<?php

use taskforce\models\task\Task;

require_once 'vendor/autoload.php';

$task = new Task('customer', 'status_new');
var_dump($task->getUserActions('status_new'));
var_dump($task->getUserActions('status_work'));

$task2 = new Task('executor', 'status_new');
var_dump($task2->getUserActions('status_new'));
var_dump($task2->getUserActions('status_work'));
