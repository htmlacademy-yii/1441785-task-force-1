<?php
require_once 'src/main/Task.php';

//Step 1 Заказчик размещает новое задание
$CurrectUser_Id = 1; //Заказчик
$Task = new Task(0);
$Task->CreateNewTask($CurrectUser_Id);
$RepoString = 'Заказчик разместил новое задание. Статус задания ' .$Task->CurrentStatus .'<br/>';
$Actions = $Task->ListActions($CurrectUser_Id);
ReportActionMap($Actions,$RepoString,$Task);


//Step 2 Исполнитель принимает задание
$CurrectUser_Id = 2; //Исполнитель
$Task->AcceptTask($CurrectUser_Id);
$RepoString = 'Исполнитель принял задание. Статус задания ' .$Task->CurrentStatus .'<br/>';
$Actions = $Task->ListActions($CurrectUser_Id);
ReportActionMap($Actions,$RepoString,$Task);

//Step 3 
$CurrectUser_Id = 1; //Заказчик
$Task->SetWorker($CurrectUser_Id);
$RepoString = 'Заказчик назначил исполниеля. Статус задания ' .$Task->CurrentStatus .'<br/>';
$Actions = $Task->ListActions($CurrectUser_Id);
ReportActionMap($Actions,$RepoString,$Task);

//Step 4 
$CurrectUser_Id = 2; //Исполнитель
$RepoString = 'Исполнитель в процессе выполнения задания. Статус задания ' .$Task->CurrentStatus .'<br/>';
$Actions = $Task->ListActions($CurrectUser_Id);
ReportActionMap($Actions,$RepoString,$Task);


function ReportActionMap($Actions,$RepoString,$Task)
{
 
    foreach($Actions as $Action)
    {
        $NextStatus = $Task->getNextStatus($Action);
        $RepoString = $RepoString .' Action "'. $Action . '" next status "' . $NextStatus . '"<br/>';
    } 
   echo $RepoString; 
   return 0;
}
