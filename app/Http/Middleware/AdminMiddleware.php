<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;

class AdminMiddleware
   {
      /**
      * This middleware counts how many users are in the Users table
      * If there are more than one users, it checks if the current authenticated User has the permission to 'Administer roles & permissions'
      * This is used for controlling access to the User/Role/Permissions admin system
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  \Closure  $next
      * @return mixed
      */
      public function handle($request, Closure $next)
         {
            $user = User::all()->count();
            if ($user != 1)
               {
                  if (!Auth::user()->hasPermissionTo('Administer Roles & Permissions'))
                     abort('401');
               }

            return $next($request);
         }
   }