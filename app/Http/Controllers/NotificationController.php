<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;



class NotificationController extends Controller
{


    public function index()
    {


        $notifications = auth()
            ->user()
            ->notifications()
            ->latest()
            ->get();



        return view(
            'notification.index',
            compact('notifications')
        );


    }







    public function read($id)
    {


        $notification = auth()
            ->user()
            ->notifications()
            ->findOrFail($id);





        $notification->markAsRead();





        if(isset($notification->data['url']))
        {


            return redirect(
                $notification->data['url']
            );


        }





        return back();


    }



}