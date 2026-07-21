<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Models\Task;
use App\Notifications\TaskDeadlineReminder;



class SendTaskDeadlineReminder extends Command
{


    protected $signature =
    'task:deadline-reminder';



    protected $description =
    'Send reminder notification for upcoming task deadlines';


    public function handle()
    {


       $tasks = Task::whereNotNull('deadline')
->whereDate(
    'deadline',
    '<=',
    now()->addDays(7)
)
->whereDate(
    'deadline',
    '>=',
    now()
)
->get();





        foreach($tasks as $task)
        {


            if($task->employee 
                && 
               $task->employee->user)
            {



                $task->employee
                ->user
                ->notify(
                    new TaskDeadlineReminder($task)
                );



            }



        }




        $this->info(
            'Deadline reminder sent'
        );


    }


}