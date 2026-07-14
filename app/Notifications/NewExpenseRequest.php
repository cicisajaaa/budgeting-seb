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

            'title' => 'Pengajuan Dana Baru',


            'message' =>
                $this->expense->user->name .
                ' mengajukan dana Rp ' .
                number_format(
                    $this->expense->jumlah
                ),



            'url' => route(
                'expense.approval'
            ),



            'expense_id'=>$this->expense->id,


        ];

    }


}