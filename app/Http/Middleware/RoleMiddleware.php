<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;



class RoleMiddleware
{


    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ): Response
    {



        /*
        |--------------------------------------------------------------------------
        | Memeriksa Status Login
        |--------------------------------------------------------------------------
        */


        if(!auth()->check())
        {


            abort(401);


        }







        /*
        |--------------------------------------------------------------------------
        | Mengambil Role Pengguna
        |--------------------------------------------------------------------------
        */


        $userRole = strtolower(

            trim(

                auth()->user()->role

            )

        );









        /*
        |--------------------------------------------------------------------------
        | Menyesuaikan Role yang Diizinkan pada Route
        |--------------------------------------------------------------------------
        */


        $allowedRoles = array_map(

            function($role){


                return strtolower(

                    trim($role)

                );


            },

            $roles

        );









        /*
        |--------------------------------------------------------------------------
        | Memeriksa Hak Akses Pengguna
        |--------------------------------------------------------------------------
        */


        if(
            !in_array(
                $userRole,
                $allowedRoles
            )
        )
        {


            abort(403);


        }








        return $next($request);


dd([
    'check'=>auth()->check(),
    'user'=>auth()->user(),
    'roles'=>$roles
]);
    }


}