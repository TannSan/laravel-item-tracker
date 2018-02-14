@extends('layouts.app')
@section('title', '| Permissions')
@section('content')
<div class="container">
   <div class="panel panel-default">
      <div class="panel-heading">
         <div class="btn-group pull-right">
            <a href="{{ route('users.index') }}" class="btn btn-default">Users</a>
            <a href="{{ route('roles.index') }}" class="btn btn-default">Roles</a>
         </div>
         <h3 class="panel-title" style="padding-top: 8px;"><i class="fa fa-key"></i>Available Permissions</h3>
         <span class="clearfix"></span>
      </div>
      <div class="panel-body">Create, edit and delete permissions.  This is the lowest level of the permission system.</div>
      <table class="table table-bordered table-striped">
         <thead>
            <tr>
               <th>Permissions</th>
               <th class="text-center" style="width: 145px">Operation</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($permissions as $permission)
            <tr>
               <td>{{ $permission->name }}</td>
               <td>
                  <a href="{{ URL::to('permissions/'.$permission->id.'/edit') }}" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>
                  <form action="/permissions/{{ $permission->id }}" method="POST">
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
         <a href="{{ URL::to('permissions/create') }}" class="btn btn-success">Add Permission</a>
      </div>
   </div>
</div>
@endsection