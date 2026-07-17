<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;


class ExpenseStatusNotification extends Notification
{

    use Queueable;


    public $expense;
    public $status;



    public function __construct($expense,$status)
    {

        $this->expense = $expense;
        $this->status = $status;

    }





    public function via($notifiable)
    {

        return [
            'database'
        ];

    }







    public function toDatabase($notifiable)
    {

        if($this->status == 'approved')
        {

            $title = "Pengajuan Dana Disetujui";

            $message =
                "Pengajuan dana Rp ".
                number_format($this->expense->jumlah).
                " telah disetujui.";

        }
        else
        {

            $title = "Pengajuan Dana Ditolak";

            $message =
                "Pengajuan dana Rp ".
                number_format($this->expense->jumlah).
                " ditolak.";

        }



        return [

            'title'=>$title,


            'message'=>$message,


            'url'=>route('expense.myhistory'),


            'expense_id'=>$this->expense->id

        ];

    }


}