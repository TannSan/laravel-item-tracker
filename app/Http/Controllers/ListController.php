<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Laravel\Facades\Pusher;

class ListController extends Controller
{
    public function __construct()
    {    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = \App\User::whereHas('roles', function($q){
            $q->whereIn('name', ['Admin', 'Editor', 'Viewer']);
        })->get();

        $list_items = json_encode(\App\ListItem::orderBy('label')->orderBy('parent_id')->get());
        return view('lists.index', compact('users', 'list_items'));
    }

    /**
     * Store or update a ListItem.
     * Also handles the deletion so we could use POST to handle multiple ids.
     * Validation Rules: https://laravel.com/docs/5.5/validation#available-validation-rules
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Delete all the ids specified
        if($request->input('item_ids'))
            {
                $ids = $request->input('item_ids');
                \App\ListItem::destroy(explode(',', $ids));
                
                Pusher::trigger('list-demo', 'ListItemDeletedEvent', [
                    'user_name' => $user->name,
                    'user_id' => $user->id,
                    'item_id' => strpos($ids, ',') === false ? $ids : substr($ids, 0, strpos($ids, ',')),
                    'item_ids' => $ids
                ]);

                return \Response::json(array('success' => true, 'item_ids' => $ids)); 
            }

        $data = $request->validate([
            'parent_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'label' => 'required|max:256'
        ]);

        // Only keep a non-zero user_id if this is a top level node and vica versa
        if($request->input('parent_id') > 0)
            $data['user_id'] = 0;
        else
            $data['parent_id'] = 0;

        // If it's a new item then save it, grab the new database ID and send it back
        $broadcast_type = "ListItemCreatedEvent";
        if($request->input('id') == 0)
            {
                $list_item = tap(new \App\ListItem($data))->save();
            }
        else
            {
                $broadcast_type = 'ListItemSavedEvent';
                $list_item = \App\ListItem::findOrFail($request->input('id'));
                $user_id = $list_item->user_id;
                $list_item->fill($data);
                $list_item->save();
            }
                
        Pusher::trigger('list-demo', $broadcast_type, [
            'user_name' => $user->name,
            'user_id' => $user->id,
            'item_id' => $list_item->id,
            'item_user_id' => (int)$list_item->user_id,
            'parent_id' => $list_item->parent_id,
            'label' => $list_item->label,
        ]);

        return \Response::json(array('success' => true, 'id' => $list_item->id)); 
    }
}
