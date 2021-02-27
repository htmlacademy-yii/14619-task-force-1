<?php

use taskforce\models\task\Task;
use taskforce\exceptions\task\StatusNotFoundException;
//use taskforce\exceptions\task\ActionNotFoundException;
use taskforce\exceptions\user\UserRuleNotFoundException;

require_once 'vendor/autoload.php';
echo "<pre>";
$task = new Task('customer', 'status_new');
var_dump($task->getUserActions('status_new'));
var_dump($task->getUserActions('status_work'));

try {
    $task = new Task('customer2', 'status_new');
} catch (UserRuleNotFoundException $e) {
    error_log(date("d.m.Y H:i:s")." Не удалось найти роль пользователя \n" ,3, "errors.log");
} catch (StatusNotFoundException $e) {
    error_log(date("d.m.Y H:i:s")." Не удалось найти статус задачи \n",3, "errors.log");
}

try {
    $task = new Task('customer', 'status_new2');
} catch (UserRuleNotFoundException $e) {
    error_log(date("d.m.Y H:i:s")." Не удалось найти роль пользователя \n" ,3, "errors.log");
} catch (StatusNotFoundException $e) {
    error_log(date("d.m.Y H:i:s")." Не удалось найти статус задачи \n",3, "errors.log");
}

echo "</pre>";

/*$task2 = new Task('executor', 'status_new');
var_dump($task2->getUserActions('status_new'));
var_dump($task2->getUserActions('status_work'));
*/
