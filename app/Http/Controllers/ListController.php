<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListController extends Controller
{
    private $list_item_helper;

    public function __construct()
    {    
        // $this->middleware(['auth', 'clearance']);  
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('lists.index')->with('list_items', json_encode(\App\ListItem::orderBy('label')->orderBy('parent_id')->get()));
      // return \Response::json(\App\ListItem::orderBy('parent_id')->get()); 
    }

    /**
     * Store or update a ListItem.
     * Validation Rules: https://laravel.com/docs/5.5/validation#available-validation-rules
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        if($request->input('id') == 0)
            {
                $list_item = tap(new \App\ListItem($data))->save();
            }
        else
            {
                $list_item = \App\ListItem::findOrFail($request->input('id'));
                $user_id = $list_item->user_id;
                $list_item->fill($data);
                $list_item->save();
            }

        return \Response::json(array('success' => true, 'id' => $list_item->id)); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /*
       $list_item = \App\ListItem::find($id);
       $list_item->delete();
       */

       return Response::json(array('success' => true)); 
    }
}
