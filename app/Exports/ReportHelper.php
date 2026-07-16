<?php

namespace App\Exports;


class ReportHelper
{


    public static function number()
    {

        return 'FIN-'.date('Y').'-001';

    }




    public static function period()
    {

        return date('F Y');

    }



}