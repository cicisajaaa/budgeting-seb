<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;


class TaskDeadlineReminder extends Notification
{

    use Queueable;


    public $task;



    public function __construct($task)
    {

        $this->task = $task;

    }




    public function via($notifiable)
    {

        return [
            'database'
        ];

    }





    public function toDatabase($notifiable)
    {


        return [


            'title' =>
                'Deadline Task Mendekati',



            'message' =>

                'Task '.
                $this->task->nama_task.
                ' akan deadline pada '.
                date(
                    'd M Y',
                    strtotime($this->task->deadline)
                ),




            'task_id'=>
                $this->task->id,



            'project'=>
                $this->task->project->nama_project ?? '-',



            'url'=>
                route(
                    'employee.task.show',
                    $this->task->id
                )


        ];


    }


}