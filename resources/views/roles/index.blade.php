@extends('layouts.app')
@section('title', '| Roles')
@section('content')
<div class="container">
   <div class="panel panel-default">
      <div class="panel-heading">
         <div class="btn-group pull-right">
            <a href="{{ route('users.index') }}" class="btn btn-default">Users</a>
            <a href="{{ route('permissions.index') }}" class="btn btn-default">Permissions</a>
         </div>
         <h3 class="panel-title" style="padding-top: 8px;"><i class="fa fa-key"></i>Roles</h3>
         <span class="clearfix"></span>
      </div>
      <div class="panel-body">Create, edit and delete roles.  This is also where permissions are assigned to roles.</div>
      <table class="table table-bordered table-striped">
         <thead>
            <tr>
               <th>Role</th>
               <th>Permissions</th>
               <th class="text-center" style="width: 145px">Operation</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($roles as $role)
            <tr>
               <td>{{ $role->name }}</td>
               <td>{{ $role->permissions()->pluck('name')->implode(', ') }}</td>
               <td>
                  <a href="{{ URL::to('roles/'.$role->id.'/edit') }}" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>
                  <form action="/roles/{{ $role->id }}" method="POST">
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
         <a href="{{ URL::to('roles/create') }}" class="btn btn-success">Add Role</a>
      </div>
   </div>
</div>
@endsection