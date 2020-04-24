<?php
//require_once 'src/main/Task.php';
require_once 'vendor/autoload.php';
use Workforce\WorkFlow\Task;

$сurrectUserId = 1; //Заказчик
$workerId = 2; //Исполнитель

$Task = new Task($сurrectUserId, $workerId);
assert($Task->currentStatus==$Task::STATUS_NEW, 'Заказ размещен статус');
assert($Task->getStatusName($Task->currentStatus)=='Новое', 'Статус заказ = Новый');
assert($Task->listActions($Task::USER_WORKER)[0]==$Task::ACTION_ACCEPT, 'Действия исполнителя  = Принять');
assert($Task->getActionName($Task->listActions($Task::USER_WORKER)[0])=='Принять', 'Действия исполнителя  = Принять');
$Task->acceptTask($сurrectUserId);
assert($Task->currentStatus==$Task::STATUS_WORK, 'Заказ принят к исполнению');
assert($Task->getStatusName($Task->currentStatus)=='Выполняется', 'Статус заказ = Выполняется');
assert($Task->getActionName($Task->listActions($Task::USER_CLIENT)[0])=='Завершить', 'Действия исполнителя  = Принять');
$Task->taskCompleted($сurrectUserId);
assert($Task->currentStatus==$Task::STATUS_DONE, 'Заказ выполнен');
