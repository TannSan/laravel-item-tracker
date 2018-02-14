<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ClearanceMiddleware
   {
      /**
      * This middleware is used in the ParseController to ensure only users with the Manage permission can use the create/edit/delete parse pages/functions
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  \Closure  $next
      * @return mixed
      */
      public function handle($request, Closure $next)
         {
            /*
            if (Auth::user()->hasPermissionTo('Administer Roles & Permissions'))
               return $next($request);
            */

            if ($request->is('parse/create') || $request->is('parse/*/edit') || $request->isMethod('Delete'))
               {
                  if (!Auth::user()->hasPermissionTo('Manage DPS Club Parses'))
                     abort('401');
                  else
                     return $next($request);
               }

            return $next($request);
         }
   }