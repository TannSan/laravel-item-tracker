<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParseController extends Controller
{
    public function __construct()
    {
      $this->middleware(['auth', 'clearance'])->except('index', 'iframeboards', 'iframesideblock');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return $this->generateScoreBoards('scoreboards');
    }

    /**
     * Display the scoreboards in a format suitable for the main site iframe
     *
     * @return \Illuminate\Http\Response
     */
    public function iframeboards()
    {
      return $this->generateScoreBoards('iframe-scoreboards');
    }

    /**
     * Display the scoreboards in a format suitable for the main site iframe
     *
     * @param  string  $view
     * @return \Illuminate\Http\Response
     */
    private function generateScoreBoards($view)
    {
      $assassins = \App\Parse::where(['advanced_class' => 'Assassin', 'is_crazy' => 0])->orderBy('parse_dps', 'desc')->take(5)->get();
      $juggernauts = \App\Parse::where(['advanced_class' => 'Juggernaut', 'is_crazy' => 0])->orderBy('parse_dps', 'desc')->take(5)->get();
      $marauders = \App\Parse::where(['advanced_class' => 'Marauder', 'is_crazy' => 0])->orderBy('parse_dps', 'desc')->take(5)->get();
      $mercenaries = \App\Parse::where(['advanced_class' => 'Mercenary', 'is_crazy' => 0])->orderBy('parse_dps', 'desc')->take(5)->get();
      $operatives = \App\Parse::where(['advanced_class' => 'Operative', 'is_crazy' => 0])->orderBy('parse_dps', 'desc')->take(5)->get();
      $powertechs = \App\Parse::where(['advanced_class' => 'Powertech', 'is_crazy' => 0])->orderBy('parse_dps', 'desc')->take(5)->get();
      $snipers = \App\Parse::where(['advanced_class' => 'Sniper', 'is_crazy' => 0])->orderBy('parse_dps', 'desc')->take(5)->get();
      $sorcerers = \App\Parse::where(['advanced_class' => 'Sorcerer', 'is_crazy' => 0])->orderBy('parse_dps', 'desc')->take(5)->get();
      $top_40 = \App\Parse::where('is_crazy', 0)->orderBy('parse_dps', 'desc')->take(40)->get();
      $top_40_crazy = \App\Parse::orderBy('parse_dps', 'desc')->take(40)->get();
      return view($view, compact("assassins", "juggernauts", "marauders", "mercenaries", "operatives", "powertechs", "snipers", "sorcerers", "top_40", "top_40_crazy"));
    }

    /**
     * Display the scoreboard sideblock in a format suitable for the main site iframe
     *
     * @return \Illuminate\Http\Response
     */
    public function iframesideblock()
    {
      $assassins = \App\Parse::where(['advanced_class' => 'Assassin', 'is_crazy' => 0])->orderBy('parse_dps', 'desc')->first();
      $juggernauts = \App\Parse::where(['advanced_class' => 'Juggernaut', 'is_crazy' => 0])->orderBy('parse_dps', 'desc')->first();
      $marauders = \App\Parse::where(['advanced_class' => 'Marauder', 'is_crazy' => 0])->orderBy('parse_dps', 'desc')->first();
      $mercenaries = \App\Parse::where(['advanced_class' => 'Mercenary', 'is_crazy' => 0])->orderBy('parse_dps', 'desc')->first();
      $operatives = \App\Parse::where(['advanced_class' => 'Operative', 'is_crazy' => 0])->orderBy('parse_dps', 'desc')->first();
      $powertechs = \App\Parse::where(['advanced_class' => 'Powertech', 'is_crazy' => 0])->orderBy('parse_dps', 'desc')->first();
      $snipers = \App\Parse::where(['advanced_class' => 'Sniper', 'is_crazy' => 0])->orderBy('parse_dps', 'desc')->first();
      $sorcerers = \App\Parse::where(['advanced_class' => 'Sorcerer', 'is_crazy' => 0])->orderBy('parse_dps', 'desc')->first();
      $top_3 = \App\Parse::where('is_crazy', 0)->orderBy('parse_dps', 'desc')->take(3)->get();
      $top_crazy = \App\Parse::orderBy('parse_dps', 'desc')->first();

      foreach ($top_3 as $parse)
         {
            $parse->advanced_class = $this->shortenClass($parse->advanced_class);
         }
      $top_crazy->advanced_class = $this->shortenClass($top_crazy->advanced_class);

      return view('iframe-sideblock', compact("assassins", "juggernauts", "marauders", "mercenaries", "operatives", "powertechs", "snipers", "sorcerers", "top_3", "top_crazy"));
    }


    /**
     * Returns a shortened version of the supplied character class name.
     *
     * @string class_name  Full classname to be shortened
     * @return string   Shortened classname
     */
    private function shortenClass($class_name)
    {
      switch($class_name)
         {
            case 'Assassin':
               return 'Sin';
               break;
            case 'Juggernaut':
               return 'Jugg';
               break;
            case 'Marauder':
               return 'Mara';
               break;
            case 'Mercenary':
               return 'Merc';
               break;
            case 'Operative':
               return 'Op';
               break;
            case 'Powertech':
               return 'PT';
               break;
            case 'Sniper':
               return $class_name;
               break;
            case 'Sorcerer':
               return 'Sorc';
               break;
         }
      return $class_name;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      if(session('parse_id') === null)
         $action_desc = 'Creating New Parse Entry';
      else
         $action_desc = 'Creating New Parse Entry Based On Parse #'.session('parse_id');
      return $this->editOrCreate($action_desc, session('parse_id'));
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
       $data = $request->validate([
           'member_name' => 'required|max:255',
           'forum_link' => 'required|url|max:255',
           'parse_link' => 'required|url|max:255',
           'parse_date' => 'required|date|max:255',
           'parse_dps' => 'required|numeric|min:8000',
           'advanced_class' => 'required|max:255',
           'specialization' => 'required|max:255'
       ]);

       // This avoids the number rounding problem.
       // The problem was if the user entered 8879.9999 then the database should chop the decimals to 2 places and have 8879.99
       // What was happening was that it was rounding the number up to it became 8880.00
       $dps = $data['parse_dps'];
       if (strpos($dps, '.') !== false)
         $data['parse_dps'] = substr($dps, 0, ((strpos($dps, '.') + 1) + 2));

       $data['is_crazy'] = $request->input('is_crazy') !== null;

       // $parse = tap(new \App\Parse($data))->save();
       $parse = \App\Parse::updateOrCreate(['member_name' => $request->input('member_name'), 'advanced_class' => $request->input('advanced_class'), 'specialization' => $request->input('specialization'), 'is_crazy' => $data['is_crazy']], $data);
       return redirect('/start')->withSuccess($parse->wasRecentlyCreated ? 'Parse Created' : 'Parse Already Existed So Updated That Entry');
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
      $action_desc = "Editing Parse #".$id;
      return $this->editOrCreate($action_desc, $id);
    }

    /**
     * Displays the edit / create page depending on how it is called
     * This is called via edit() and create() but also serves a third purpose which is "Create entry based on another entry"
     * That makes it easy for the user to select a previous entry that serves as the basis for a new one so they don't have to fill out all the fields again
     * @param  string  $action_desc
     * @param  int     $id
     * @return \Illuminate\Http\Response
     */
    private function editOrCreate($action_desc, $id = null)
    {
      if ($id === null)
         {
            $parse = new \App\Parse();
            return view('edit', compact('action_desc', 'parse'));
         }
      else
         {
            $parse = \App\Parse::find($id);

            // Strip the time element from the Parse Date
            $pure_date = new \DateTime($parse['parse_date']);
            $parse['parse_date'] = $pure_date->format('Y-m-d');

            if(session('parse_id') === null)
               return view('edit', compact('action_desc', 'id', 'parse'));
            else
               return view('edit', compact('action_desc', 'parse'));
         }
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
           'member_name' => 'required|max:255',
           'forum_link' => 'required|url|max:255',
           'parse_link' => 'required|url|max:255',
           'parse_date' => 'required|date|max:255',
           'parse_dps' => 'required|numeric|min:8000',
           'advanced_class' => 'required|max:255',
           'specialization' => 'required|max:255'
       ]);

       // This avoids the number rounding problem.
       // The problem was if the user entered 8879.9999 then the database should chop the decimals to 2 places and have 8879.99
       // What was happening was that it was rounding the number up to it became 8880.00
       $dps = $data['parse_dps'];
       if (strpos($dps, '.') !== false)
         $data['parse_dps'] = substr($dps, 0, ((strpos($dps, '.') + 1) + 2));

       $data['is_crazy'] = $request->input('is_crazy') !== null;

       $parse = \App\Parse::findOrFail($id);
       $parse->fill($data);
       $parse->save();

       return redirect('/start')->withSuccess('Parse Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $parse = \App\Parse::find($id);
       session(['deleted_count' => 0]);
       session(['success' => 'Deleted Parse: '.$parse['member_name'].' - '.$parse['advanced_class'].' - '.$parse['specialization'].' - '.$parse['parse_dps'].($parse['is_crazy'] == 1 ? ' (Crazy)' : '' )]);
       $parse->delete();
    }
}
