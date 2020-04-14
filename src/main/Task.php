<?php

class Task
{
        const STATUS_NEW = 'Новое';
	const STATUS_WORK = 'В Работе';
	const STATUS_DONE = 'Сделано';
	const STATUS_CANCEL = 'Отменено';

        //Действия Заказчика
	const ACTION_SETWORKER = 'Выбрать исполнителя';
	const ACTION_CANCEL = 'Отменить';
	const ACTION_CLOSE = 'Закрыть';
        
        //Действия Исполнитетеля
	const ACTION_ACCEPT = 'Принять';
	const ACTION_CANCELACCEPTED = 'Отменить принятие';
        
        //Действия общие
	const ACTION_MESSAGE = 'Написать сообщение';

	
	private $Client_Id = 0; //Идентификатор заказчика
	private $Worker_Id = 0; //Идентификатор исполнителя может быть = 0 пока задание не принято исполнителем 
        private $Worker_id_list = [];


        public $CurrentStatus = '';
	public $Task_Id = 0; //Идентификатор задания
	
	//Task_id = 0 если задание еще не создано (нет записи в бд)
	//, CurrectUser_Id определит роль пользователся существующего задания  и будет присвоено Client_Id нового задания 
	public function __constuct($Task_Id)  //конструктор
	{
		
	}
	
	//Действия Заказчика
	public function CreateNewTask($Client_Id)  //Создать новое задание
	{
		$this->Client_Id = $Client_Id;
                $this->CurrentStatus = Task::STATUS_NEW;
	}
	
	public function CancelTask()  //Отменить задание
	{
                $this->CurrentStatus = Task::STATUS_CANCEL;		
	}
	
	public function SetWorker($CurrectUser_Id)  //Выбрать исполнителя
	{
            if (($CurrectUser_Id == $this->Client_Id) and isset($this->Worker_id_list[0]))
            {
		$this->Worker_Id = $this->Worker_id_list[0];	// пока всегда первый
                $this->CurrentStatus = Task::STATUS_WORK;
            }    
	}
	
	public function TaskCompleted()  //Принять задание (отметить как выполненное)
	{
            $this->CurrentStatus = Task::STATUS_DONE;
	}


	//Действия Исполнителя
	public function AcceptTask($CurrectUser_Id)  //Принять задание
	{
            $this->Worker_id_list[] = $CurrectUser_Id;	
	}
	
	public function CancelAcceptTask()  //Отказаться от  задания
	{
            $this->Worker_Id = 0;	
            $this->CurrentStatus = Task::STATUS_NEW;
	}
	
	
	// Общее действие, доступно исполнителю и заказчику
	public function WriteMessage($CurrectUser_Id)  //Написать сообщения
	{

	}
	
	
	public function  ListActions($CurrectUser_Id) //Список доступных действий
	{
            $ListClientActions = [  Task::STATUS_NEW => [Task::ACTION_SETWORKER, Task::ACTION_CANCEL],
                                    Task::STATUS_WORK => [Task::ACTION_CLOSE]
                    ];
            
            
            $ListWorkerActions= [  Task::STATUS_NEW => [Task::ACTION_ACCEPT],
                                    Task::STATUS_WORK => [Task::ACTION_CANCELACCEPTED]
                    ];
            
            $ListActions = [];
            
            if ($CurrectUser_Id == $this->Client_Id)
            {
                    $ListActions =  $ListClientActions[$this->CurrentStatus];
            }       
            else
            {
                    $ListActions =  $ListWorkerActions[$this->CurrentStatus];                
            }
            if (($this->CurrentStatus == Task::STATUS_NEW) or ($this->CurrentStatus == Task::STATUS_WORK))
                {$ListActions[] = Task::ACTION_MESSAGE;}
            return $ListActions;        
	}

	public function getNextStatus($Action) //Статус после действия
	{
            $NextStatus = $this->CurrentStatus;
            $StatusMap = [  Task::ACTION_SETWORKER => Task::STATUS_WORK, Task::ACTION_CANCEL => Task::STATUS_CANCEL, Task::ACTION_CLOSE => Task::STATUS_DONE, Task::ACTION_CANCELACCEPTED  => Task::STATUS_NEW];
            if (isset($StatusMap[$Action])) 
                {$NextStatus = $StatusMap[$Action];}
            return $NextStatus;
            
	}
	
}