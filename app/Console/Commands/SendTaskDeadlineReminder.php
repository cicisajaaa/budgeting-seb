<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Models\Tugas;
use App\Notifications\TaskDeadlineReminder;



class SendTaskDeadlineReminder extends Command
{


    protected $signature =
    'task:deadline-reminder';



    protected $description =
    'Mengirim notifikasi pengingat tenggat tugas yang akan datang';


    public function handle()
    {


        $tasks = Tugas::whereNotNull('deadline')

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


            if(
                $task->karyawan
                &&
                $task->karyawan->pengguna
            )
            {



                $task->karyawan

                ->pengguna

                ->notify(

                    new TaskDeadlineReminder($task)

                );



            }



        }




        $this->info(

            'Pengingat deadline berhasil dikirim'

        );


    }


}