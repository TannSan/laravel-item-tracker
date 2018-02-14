@extends('layouts.app')
@section('title', '| Edit Permission')
@section('content')
<div class="container">
   <div class="panel panel-default">
      <div class="panel-heading"><h3 class="panel-title" style="padding-top: 8px; padding-bottom: 10px;"><i class='fa fa-key'></i> {{ isset($permission->id) ? 'Edit '.$permission->name : 'Add Permission' }}</h3></div>
      @isset($permission->id)
      <form action="/permissions/{{ $permission->id }}" method="post">
         {{ method_field('PUT') }}
      @else
      <form action="/permissions" method="post">
      @endisset
         {!! csrf_field() !!}
         <div class="panel-body">
            @include ('errors.list')
            <div class="form-group">
               <label for="name">Permission Name</label>
               <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name', isset($permission->id) ? $permission->name : '') }}">
            </div>
            {{--
            @if(!$roles->isEmpty())
            <h4>Assign Permission to Roles</h4>
            @foreach ($roles as $role)
            <label><input type="checkbox" class="form-control" id="roles[]" name="roles[]" value="{{ $role->id }}"> {{ ucfirst($role->name) }}</label>
            @endforeach
            @endif
            --}}
         </div>
         <div class="panel-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-default" href="/permissions">Cancel</a>
         </div>
      </form>
   </div>
</div>
@endsection