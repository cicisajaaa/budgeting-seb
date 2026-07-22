<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;


class TaskDeadlineReminder extends Notification
{

    use Queueable;


    public $tugas;



    public function __construct($tugas)
    {

        $this->tugas = $tugas;

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

                'Deadline Tugas Mendekati',



            'message' =>


                'Tugas '.

                $this->tugas->nama_tugas.

                ' akan deadline pada '.

                date(

                    'd M Y',

                    strtotime(
                        $this->tugas->deadline
                    )

                ),




            'task_id' =>

                $this->tugas->id,



            'project' =>

                $this->tugas->proyek->nama_proyek ?? '-',



            'url' =>

                route(

                    'employee.task.show',

                    $this->tugas->id

                )


        ];


    }


}