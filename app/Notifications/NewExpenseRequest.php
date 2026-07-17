<?php

namespace App\Notifications;


use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;



class NewExpenseRequest extends Notification
{

    use Queueable;



    public $expense;




    public function __construct($expense)
    {

        $this->expense = $expense;

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
                'Pengajuan Dana Baru',





            'message' =>

                ($this->expense->user->name ?? 'Karyawan')

                .

                ' mengajukan dana sebesar Rp '

                .

                number_format(
                    $this->expense->jumlah,
                    0,
                    ',',
                    '.'
                ),






            'project' =>

                $this->expense->project->nama_project ?? '-',






            'division' =>

                $this->expense->division->nama_divisi ?? '-',






            'jumlah' =>

                $this->expense->jumlah,






            'expense_id' =>

                $this->expense->id,







            'url' =>

                route(
                    'expense.approval'
                ),





        ];


    }


}