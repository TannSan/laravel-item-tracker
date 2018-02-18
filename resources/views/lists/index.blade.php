@extends('layouts.app')
@section('content')
    <div class="container">
        @hasanyrole('Admin|Editor')
        <div class="row">
            <div class="col-sm-4">
                <div class="panel panel-default panel-new-template">
                    <div class="panel-heading">
                        <h3 class="panel-title">Drag New Item</h3>
                    </div>
                    <ol class='sortable-list new-container'>
                        <li data-id="0" data-label="New Item" id="new-item"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="New Item" placeholder="Enter Item Name" maxlength="256" disabled="disabled" /></div></li>
                        <li data-id="0" data-label="New Item" id="new-template" style="display: none;"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="New Item" maxlength="256" placeholder="Enter Item Name" disabled="disabled" /></div></li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-default panel-item-killer">
                    <div class="panel-heading">
                        <h3 class="panel-title">Drop Here To Delete</h3>
                    </div>
                    <ol class='sortable-list kill-container'><li><img src="/img/trashcan.png" alt="Drop here to delete" id="trashcan" /></li></ol>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Log</h3>
                    </div>
                    <div class="panel-body">
                        <textarea id="item-log" class="form-control" readonly="readonly"></textarea>
                    </div>
                </div>
            </div>
        </div>
        @endhasanyrole
        @php ($mod = count($users) % 2 ? 3 : 2)
        @php ($col_css = $mod == 3 ? 'col-sm-4' : 'col-sm-6')
        @php ($counter = 0)
        @foreach ($users as $user)
            @if ($counter == 0)
            <div class="row">
            @endif
                <div class="{{ $col_css }}">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{ $user['name'] }}</h3>
                        </div>
                        <ol class='sortable-list user-container' data-user-id="{{ $user['id'] }}"></ol>
                    </div>
                </div>
                @php ($counter++)
            @if ($counter == $mod)
            </div>
            @php ($counter = 0)
            @endif
        @endforeach
    <script type="text/javascript">
        @hasanyrole('Admin|Editor')
        var interactive = true;
        @else
        var interactive = false;
        @endhasanyrole
        var list_items = {!! $list_items !!};
        var user_id = {{ Auth::id() }};
    </script>
@endsection