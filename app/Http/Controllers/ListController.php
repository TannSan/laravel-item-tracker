<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListController extends Controller
{
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
      $list_items = \App\ListItem::orderBy('user_id', 'desc')->orderBy('parent_id', 'desc')->get();

      $grouped_items = $list_items->groupBy('parent_id');

      // return view('/list')->with('list_items', json_encode($list_items));
      return \Response::json($grouped_items); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $action_desc = 'Creating New Item';
      $list_item = new \App\ListItem();
      return view('edit', compact('action_desc', 'list_item'));
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

        return \Response::json(array(
             'success' => true,
             'id' => $list_item->id
         )); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $action_desc = "Editing Item With ID".$id;
      $parse = \App\Parse::find($id);
      return view('edit', compact('action_desc', 'id', 'parse'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $data = $request->validate([
           'parent_category_id' => 'required|numeric',
           'sort_order' => 'required|numeric',
           'label' => 'required|max:256'
       ]);
       $data['is_category'] = $request->input('is_category') !== null;

       $list_item = \App\ListItem::findOrFail($id);
       $list_item->fill($data);
       $list_item->save();

       return redirect('/list')->withSuccess('Item Updated');
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

       return Response::json(array(
            'success' => true,
            'data'   => 'test=worked'
        )); 
    }
}
