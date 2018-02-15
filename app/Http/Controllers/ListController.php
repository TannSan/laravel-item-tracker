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
      $list_items = \App\ListItem::all();
      return view('/list')->with('list_items', $list_items);
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
     * Store a newly created resource in storage.
     *
     * Validation Rules: https://laravel.com/docs/5.5/validation#available-validation-rules
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return \Response::json(array(
             'success' => true,
             'test'   => 'worked-'.$request->input('testsend'),
             'anothertest' => 'yaaaay'
         )); 
/*
       $data = $request->validate([
           'parent_category_id' => 'required|numeric',
           'sort_order' => 'required|numeric',
           'label' => 'required|max:256'
       ]);
       $data['is_category'] = $request->input('is_category') !== null;
       $list_item = tap(new \App\ListItem($data))->save();
       return redirect('/list')->withSuccess('Item Created');
       */
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