@extends('layouts.app')
@section('title', '| Users')
@section('content')
<div class="container">
   <div class="panel panel-default">
      <div class="panel-heading">
         <div class="btn-group pull-right">
            <a href="{{ route('roles.index') }}" class="btn btn-default">Roles</a>
            <a href="{{ route('permissions.index') }}" class="btn btn-default">Permissions</a>
         </div>
         <h3 class="panel-title" style="padding-top: 8px;"><i class="fa fa-users"></i>User Administration</h3>
         <span class="clearfix"></span>
      </div>
      <div class="panel-body">Create, edit and delete permissions.  This is the lowest level of the permission system.</div>
      <table class="table table-bordered table-striped">
         <thead>
            <tr>
               <th>Name</th>
               <th>Email</th>
               <th>Date/Time Added</th>
               <th>User Roles</th>
               <th class="text-center" style="width: 145px">Operations</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($users as $user)
            <tr>
               <td>{{ $user->name }}</td>
               <td>{{ $user->email }}</td>
               <td>{{ $user->created_at->format('F d, Y h:ia') }}</td>
               <td>{{ $user->roles()->pluck('name')->implode(' ') }}</td>
               <td><a href="{{ route('users.edit', $user->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>
                  <form action="/users/{{ $user->id }}" method="POST">
                     {!! csrf_field() !!}
                     {{ method_field('DELETE') }}
                     <button type="submit" class="btn btn-danger">Delete</button>
                  </form>
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>
      <div class="panel-footer">
         <a href="{{ route('users.create') }}" class="btn btn-success">Add User</a>
      </div>
   </div>
</div>
@endsection