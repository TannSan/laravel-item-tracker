@extends('layouts.app')
@section('content')
    <div class="container">
        <ul id="messages" class="list-group"></ul>
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Mark</h3>
                    </div>
                    <ol class='sortable-list user-container' data-user-id="2"></ol>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Sandy</h3>
                    </div>
                    <ol class='sortable-list user-container' data-user-id="3"></ol>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default panel-new-template">
                    <div class="panel-heading">
                        <h3 class="panel-title">Drag New Item</h3>
                    </div>
                    <ol class='sortable-list new-container'>
                        <li data-id="0" data-label="New Item" id="new-item"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="New Item" placeholder="Enter Item Name" maxlength="256" disabled="disabled" /></div></li>
                        <li data-id="0" data-label="New Item" id="new-template" style="display: none;"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="New Item" maxlength="256" placeholder="Enter Item Name" disabled="disabled" /></div></li>
                    </ol>
                </div>
                <div class="panel panel-default panel-item-killer">
                    <div class="panel-heading">
                        <h3 class="panel-title">Drop Here To Delete</h3>
                    </div>
                    <ol class='sortable-list kill-container'><li><img src="/img/trashcan.png" alt="Drop here to delete" /></li></ol>
                </div>
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
    </div>
    <script type="text/javascript">
        var user_id = {{ Auth::id() }};
        var list_items = {!! $list_items !!};
    </script>
@endsection