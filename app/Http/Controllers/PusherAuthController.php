<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Laravel\Facades\Pusher;

/**
 * Not currently used but may be useful for future expansion.
 */
class PusherAuthController extends Controller
{
    //accessed through '/pusher/'
    private $pusher;

    public function __construct() {
        //Let's register our pusher application with the server.
        $this->pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), array('cluster' => env('PUSHER_APP_CLUSTER'), 'encrypted' => true));
    }

    /**
     * Authenticates logged-in user in the Pusher JS app
     * For presence channels
     */
    public function postAuth(Request $request)
    {
        //We see if the user is logged in our laravel application.
        if(\Auth::check())
        {
            //Fetch User Object
            $user =  \Auth::user();
            //Presence Channel information. Usually contains personal user information.
            //See: https://pusher.com/docs/client_api_guide/client_presence_channels
            //$presence_data = array('name' => $user->first_name." ".$user->last_name);
            //Registers users' presence channel.
            //echo $this->pusher->presence_auth(Input::get('channel_name'), Input::get('socket_id'), $user->id, $presence_data);       
            //echo $this->pusher->presence_auth(Input::get('channel_name'), Input::get('socket_id'), $user->id);    
            //echo $this->pusher->socket_auth($request->input('channel_name'), $request->input('socket_id'));   
            //echo $request->channel_name . ' - ' . $request->input('channel_name');
            echo Pusher::socket_auth($request->channel_name, $request->socket_id);   
        }
        else
        {
            return Response::make('Forbidden',403);
        }
    }
}