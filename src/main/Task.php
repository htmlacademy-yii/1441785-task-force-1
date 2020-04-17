<?php

class Task
{
	const STATUS_NEW = 'New';
	const STATUS_WORK = 'inWork';
	const STATUS_DONE = 'Done';
	const STATUS_CANCEL = 'Canceled';

        //Действия Заказчика
	const ACTION_CANCEL = 'Cancel';
	const ACTION_CLOSE = 'Completed';
        
        //Действия Исполнитетеля
	const ACTION_ACCEPT = 'Accept';
	const ACTION_CANCELACCEPTED = 'CancelAccepted';
        
        //Действия общие
	const ACTION_MESSAGE = 'Message';

	
	private $clientId; //Идентификатор заказчика
	private $workerId ; //Идентификатор исполнителя 
	private $statusActionResults;


	public $currentStatus;
	private $statusMap;
        
	
	public function __construct($currentUser, $workerID)  //конструктор
	{
            //echo 'Construct me';
            $this->clientId = $currentUser;
            $this->currentStatus = self::STATUS_NEW;
            $this->workerId = $workerID;
            $this->statusActionResults = [self::ACTION_CANCEL => self::STATUS_CANCEL, self::ACTION_CLOSE => self::STATUS_DONE, self::ACTION_CANCELACCEPTED  => self::STATUS_NEW];        
            $this->statusMap = [self::STATUS_NEW  => 'Новое',self::STATUS_WORK  => 'Выполняется',self::STATUS_CANCEL  => 'Отменено',self::STATUS_DONE  => 'Завершено'
                               ,self::ACTION_CANCEL => 'Отменить', self::ACTION_CLOSE => 'Завершить', self::ACTION_ACCEPT  => 'Принять', self::ACTION_CANCELACCEPTED  => 'Отказаться'         
                               ,self::ACTION_MESSAGE => 'Написать'];        
	}
	
	
	public function CancelTask()  //Отменить задание
	{
                $this->currentStatus = self::STATUS_CANCEL;		
	}
	
	
	public function TaskCompleted()  //Принять задание (отметить как выполненное)
	{
            $this->currentStatus = self::STATUS_DONE;
	}


	//Действия Исполнителя
	public function AcceptTask($сurrectUserId)  //Принять задание
	{
            $this->currentStatus = self::STATUS_WORK;		
	}
	
	public function CancelAcceptTask()  //Отказаться от  задания
	{
            $this->currentStatus = self::STATUS_NEW;
	}
	
	
	// Общее действие, доступно исполнителю и заказчику
	public function WriteMessage($сurrectUserId)  //Написать сообщения
	{
            //echo 'Write me';
	}
	
	
	public function  ListActions($сurrectUserId) //Список доступных действий
	{
            $ListClientActions = [  self::STATUS_NEW => [self::ACTION_CANCEL],
                                    self::STATUS_WORK => [self::ACTION_CLOSE]
                    ];
            
            
            $ListWorkerActions= [  self::STATUS_NEW => [self::ACTION_ACCEPT],
                                    self::STATUS_WORK => [self::ACTION_CANCELACCEPTED]
                    ];
            
            $ListActions = [];
            
            if ($сurrectUserId == $this->Client_Id)
            {
                    $ListActions =  $ListClientActions[$this->currentStatus];
            }       
            else
            {
                    $ListActions =  $ListWorkerActions[$this->currentStatus];                
            }
            if (($this->currentStatus == self::STATUS_NEW) or ($this->currentStatus == self::STATUS_WORK))
                {$ListActions[] = self::ACTION_MESSAGE;}
            return $ListActions;        
	}

	public function getNextStatus($Action) //Статус после действия
	{
            $NextStatus = $this->currentStatus;            
            if (isset($this->statusActionResults[$Action])) 
                {$NextStatus = $this->statusActionResults[$Action];}
            return $NextStatus;
            
	}

        public function getStatusName($Status) //Статус 
	{
            return $this->statusMap[$Status];
            
	}

        public function getActionName($Action) //Статус 
	{
            return $this->statusMap[$Action];
            
	}

}