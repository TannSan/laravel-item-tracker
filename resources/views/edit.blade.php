@extends('layouts.app')
@section('content')
   <div class="container">
      <div class="panel panel-default">
         <div class="panel-heading"><h3 class="panel-title" style="padding-top: 8px; padding-bottom: 10px;">{{ $action_desc }}</h3></div>
         @if (isset($id))
         <form action="/parse/{{ $id }}" method="post">
             {{ method_field('PUT') }}
         @else
         <form action="/parse" method="post">
         @endif
            <div class="panel-body">
                {!! csrf_field() !!}
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        Please fix the following errors
                    </div>
                @endif
                <div class="form-group{{ $errors->has('member_name') ? ' has-error' : '' }}">
                    <label for="member_name">Member Name</label>
                    <input type="text" class="form-control" id="member_name" name="member_name" placeholder="Member Name" value="{{ old('member_name', $parse->member_name) }}">
                    @if($errors->has('member_name'))
                        <span class="help-block">{{ $errors->first('member_name') }}</span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('forum_link') ? ' has-error' : '' }}">
                    <label for="forum_link">Forum Link</label>
                    <input type="text" class="form-control" id="forum_link" name="forum_link" placeholder="Forum Link" value="{{ old('forum_link', $parse->forum_link) }}">
                    @if($errors->has('forum_link'))
                        <span class="help-block">{{ $errors->first('forum_link') }}</span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('parse_link') ? ' has-error' : '' }}">
                    <label for="parse_link">Parse Link</label>
                    <input type="text" class="form-control" id="parse_link" name="parse_link" placeholder="Parse Link" value="{{ old('parse_link', $parse->parse_link) }}">
                    @if($errors->has('parse_link'))
                        <span class="help-block">{{ $errors->first('parse_link') }}</span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('parse_date') ? ' has-error' : '' }}">
                    <label for="parse_date">Date</label>
                    <input type="text" class="form-control" id="parse_date" name="parse_date" placeholder="Date" value="{{ old('parse_date', $parse->parse_date) }}">
                    @if($errors->has('parse_date'))
                        <span class="help-block">{{ $errors->first('parse_date') }}</span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('parse_dps') ? ' has-error' : '' }}">
                    <label for="parse_dps">DPS</label>
                    <input type="text" class="form-control" id="parse_dps" name="parse_dps" placeholder="DPS" value="{{ old('parse_dps', $parse->parse_dps) }}">
                    @if($errors->has('parse_dps'))
                        <span class="help-block">{{ $errors->first('parse_dps') }}</span>
                    @endif
                </div>
                <div class="form-group class_spec">
                   <label for="advanced_class">Class &amp; Spec</label>
                   <div class="form-inline">
                      <div class="form-group{{ $errors->has('advanced_class') ? ' has-error' : '' }}">
                          <select class="form-control" id="advanced_class" name="advanced_class" data-selected="{{ old('advanced_class', $parse->advanced_class) }}">
                             <option value="Assassin">Assassin</option>
                             <option value="Juggernaut">Juggernaut</option>
                             <option value="Marauder">Marauder</option>
                             <option value="Mercenary">Mercenary</option>
                             <option value="Operative">Operative</option>
                             <option value="Powertech">Powertech</option>
                             <option value="Sniper">Sniper</option>
                             <option value="Sorcerer">Sorcerer</option>
                          </select>
                      </div><div class="form-group{{ $errors->has('specialization') ? ' has-error' : '' }}">
                          <!-- <input type="hidden" class="hidden" id="specialization" name="specialization" value="{{ old('specialization', $parse->Specialization) }}"> -->
                          <select class="form-control" id="specialization" name="specialization" data-selected="{{ old('specialization', $parse->specialization) }}"></select>
                      </div>
                       @if($errors->has('advanced_class'))
                           <span class="help-block">{{ $errors->first('advanced_class') }}</span>
                       @endif

                       @if($errors->has('specialization'))
                           <span class="help-block">{{ $errors->first('specialization') }}</span>
                       @endif
                  </div>
                </div>
                <div class="form-group{{ $errors->has('is_crazy') ? ' has-error' : '' }}">
                     <label for="is_crazy">Is Crazy Parse?</label>
                     <div class="checkbox">
                         <label><input type="checkbox" class="form-control" id="is_crazy" name="is_crazy" {{ old('is_crazy', $parse->is_crazy) == 1 ? 'checked="checked"' : '' }} data-toggle="toggle" data-on="Is Crazy" data-off="Is Not Crazy" data-onstyle="danger" data-offstyle="default"></label>
                        @if($errors->has('is_crazy'))
                           <span class="help-block">{{ $errors->first('is_crazy') }}</span>
                        @endif
                     </div>
                </div>
            </div>
            <div class="panel-footer">
               <button type="submit" class="btn btn-default">Submit</button>
               <a class="btn btn-default" href="/start">Cancel</a>
            </div>
         </form>
      </div>
   </div>
@endsection