@extends('layouts.app')
@section('content')
   <div class="container">
      <div class="panel panel-default">
         <div class="panel-heading"><h3 class="panel-title" style="padding-top: 8px; padding-bottom: 10px;">Starting Points</h3></div>
         <div class="panel-body">
            <form action="/start" method="post">
                {!! csrf_field() !!}
                @if (session('success'))
                    <div class="alert alert-success" role="alert">{{session('success')}}</div>
                @endif
                <div class="form-group">
                    <label for="member_name">Create a brand new parse</label>
                </div>
                <button type="submit" class="btn btn-default" name="startbutton" value="create">Create</button>
                <hr />
                <div class="form-group{{ $errors->has('previous_parse_id') ? ' has-error' : '' }}">
                    <label for="previous_parse_id">Edit a previous parse</label>
                    <select class="form-control" id="previous_parse_id" name="previous_parse_id">
                       @foreach ($parses as $previous_parse)
                       <option value="{{ $previous_parse->id }}" {{ $previous_parse->id === old('previous_parse_id') ? 'selected="selected"' : '' }}>{{ $previous_parse->member_name }} - {{ $previous_parse->advanced_class }} - {{ $previous_parse->specialization }} - {{ $previous_parse->parse_dps }}{{ $previous_parse->is_crazy == 1 ? ' (Crazy)' : '' }}</option>
                       @endforeach
                    </select>
                    @if($errors->has('previous_parse_id'))
                        <span class="help-block">You must select a previous parse to use</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-default" name="startbutton" value="edit">Edit</button>
                <hr />
                <div class="form-group{{ $errors->has('create_from_previous_parse_id') ? ' has-error' : '' }}">
                    <label for="create_from_previous_parse_id">Create a new parse based off a previous parse</label>
                    <select class="form-control" id="create_from_previous_parse_id" name="create_from_previous_parse_id">
                       @foreach ($parses as $previous_parse)
                       <option value="{{ $previous_parse->id }}"{{ $previous_parse->id === old('create_from_previous_parse_id') ? 'selected="selected"' : '' }}>{{ $previous_parse->member_name }} - {{ $previous_parse->advanced_class }} - {{ $previous_parse->specialization }} - {{ $previous_parse->parse_dps }}{{ $previous_parse->is_crazy == 1 ? ' (Crazy)' : '' }}</option>
                       @endforeach
                    </select>
                    @if($errors->has('create_from_previous_parse_id'))
                        <span class="help-block">You must select a previous parse to use</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-default" name="startbutton" value="create_from_previous">Create</button>
                <hr />
                <div class="form-group{{ $errors->has('delete_parse_id') ? ' has-error' : '' }}">
                    <label for="delete_parse_id">Delete a parse</label>
                    <select class="form-control" id="delete_parse_id" name="delete_parse_id">
                       @foreach ($parses as $previous_parse)
                       <option value="{{ $previous_parse->id }}"{{ $previous_parse->id === old('delete_parse_id') ? 'selected="selected"' : '' }}>{{ $previous_parse->member_name }} - {{ $previous_parse->advanced_class }} - {{ $previous_parse->specialization }} - {{ $previous_parse->parse_dps }}{{ $previous_parse->is_crazy == 1 ? ' (Crazy)' : '' }}</option>
                       @endforeach
                    </select>
                    @if($errors->has('delete_parse_id'))
                        <span class="help-block">You must select a previous parse if you want to delete one!</span>
                    @endif
                </div>
                <a class="btn btn-default" data-toggle="confirmation" data-singleton="true" data-popout="true" data-btn-ok-class="btn-success" data-btn-cancel-class="btn-danger">Delete</a>
            </form>
         </div>
      </div>
   </div>
@endsection