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


        if(!auth()->check())
        {
            abort(401);
        }




        $userRole = strtolower(
            trim(
                auth()->user()->role
            )
        );





        $allowedRoles = array_map(

            function($role){

                return strtolower(
                    trim($role)
                );

            },

            $roles

        );






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

    }

}