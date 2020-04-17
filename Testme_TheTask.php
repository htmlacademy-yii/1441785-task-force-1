<?php
require_once 'src/main/Task.php';

//Step 1 Заказчик размещает новое задание
$сurrectUserId = 1; //Заказчик
$workerId = 2; //Исполнитель
$Task = new Task($сurrectUserId,$workerId);
//$Task->WriteMessage($сurrectUserId); 
assert($Task->currentStatus==$Task::STATUS_NEW, 'Заказ размещен статус');
assert($Task->getStatusName($Task->currentStatus)=='Новое', 'Статус заказ = Новый');
$Task->AcceptTask($сurrectUserId);
assert($Task->currentStatus==$Task::STATUS_WORK, 'Заказ принят к исполнению');
assert($Task->getStatusName($Task->currentStatus)=='Выполняется', 'Статус заказ = Выполняется');
$Task->TaskCompleted($сurrectUserId);
assert($Task->currentStatus==$Task::STATUS_DONE, 'Заказ выполнен');
assert($Task->getStatusName($Task->currentStatus)=='Завершено', 'Статус заказ = Завершено');
assert($Task->getActionName($Task::ACTION_CLOSE)=='Завершить', 'На кнопке напишем Завершить');
