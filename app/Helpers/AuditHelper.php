<?php

namespace App\Helpers;


use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;



class AuditHelper
{


    public static function create(
        $action,
        $module,
        $description
    )
    {


        AuditLog::create([


            'user_id' =>
                Auth::id(),


            'action' =>
                $action,


            'module' =>
                $module,


            'description' =>
                $description,


            'ip_address' =>
                request()->ip()


        ]);


    }



}