@extends('layouts.app')
@section('title', '| Edit Role')
@section('content')
<div class="container">
   <div class="panel panel-default">
      <div class="panel-heading"><h3 class="panel-title" style="padding-top: 8px; padding-bottom: 10px;"><i class='fa fa-key'></i> {{ isset($role) ? 'Edit '.$role->name : 'Add Role' }}</h3></div>
      @isset($role)
      <form action="/roles/{{ $role->id }}" method="post">
         {{ method_field('PUT') }}
      @else
      <form action="/roles" method="post">
      @endisset
         {!! csrf_field() !!}
         <div class="panel-body">
            @include ('errors.list')
            <div class="form-group">
               <label for="name">Role Name</label>
               <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name', isset($role) ? $role->name : '') }}">
            </div>
            <label for="name">Permissions</label>
            @foreach ($permissions as $permission)
            <div class="checkbox"><label><input type="checkbox" id="permissions[]" name="permissions[]" value="{{ $permission->id }}"{{ isset($role) && $role->hasPermissionTo($permission->name) ? ' checked="checked"' : '' }}>{{ ucfirst($permission->name) }}</label></div>
            @endforeach
         </div>
         <div class="panel-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-default" href="/roles">Cancel</a>
         </div>
      </form>
   </div>
</div>
@endsection