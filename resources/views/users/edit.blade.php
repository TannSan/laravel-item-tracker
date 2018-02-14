@extends('layouts.app')
@section('title', '| Add User')
@section('content')
<div class="container">
   <div class="panel panel-default">
      <div class="panel-heading"><h3 class="panel-title" style="padding-top: 8px; padding-bottom: 10px;"><i class='fa fa-user-plus'></i> {{ isset($user) ? 'Edit User' : 'Add User' }}</h3></div>
      @isset($user)
      <form action="/users/{{ $user->id }}" method="post">
         {{ method_field('PUT') }}
      @else
      <form action="/users" method="post">
      @endisset
         {!! csrf_field() !!}
         <div class="panel-body">
            @include ('errors.list')
            <div class="form-group">
               <label for="name">Name</label>
               <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name', isset($user) ? $user->name : '') }}">
            </div>
            <div class="form-group">
               <label for="email">Email</label>
               <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email', isset($user) ? $user->email : '') }}">
            </div>
            <label>Roles</label>
            @foreach ($roles as $role)
            <div class="checkbox"><label><input type="checkbox" id="roles[]" name="roles[]" value="{{ $role->id }}"{{ isset($user) && $user->hasRole($role->name) ? ' checked="checked"' : '' }}> {{ ucfirst($role->name) }}</label></div>
            @endforeach
            <div class="form-group">
               <label for="password">Password</label>
               <input type="password" class="form-control" id="password" name="password" value="">
            </div>
            <div class="form-group">
               <label for="password_confirmation">Confirm Password</label>
               <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="">
            </div>
         </div>
         <div class="panel-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-default" href="/users">Cancel</a>
         </div>
      </form>
   </div>
</div>
@endsection