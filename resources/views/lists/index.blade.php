@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Mark</h3>
                    </div>
                    <ol class='sortable-list user-container' data-user-id="2">
                        {{--
                        <li data-id="1"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="First" placeholder="Enter Item Name" /></div><ol></ol></li>
                        <li data-id="2"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="Second" placeholder="Enter Item Name" /></div><ol></ol></li>
                        <li data-id="3"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="Third" placeholder="Enter Item Name" /></div><ol></ol></li>
                        <li data-id="4"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="Fourth" placeholder="Enter Item Name" /></div><ol><li data-id="25"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="Subby" placeholder="Enter Item Name" /></div><ol></ol></li></ol></li>
                        <li data-id="5"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="Fifth" placeholder="Enter Item Name" /></div><ol></ol></li>
                        <li data-id="6"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="Sixth" placeholder="Enter Item Name" /></div><ol></ol></li>
                        <li data-id="7"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="Seventh" placeholder="Enter Item Name" /></div><ol></ol></li>
                        <li data-id="8"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="Eigth" placeholder="Enter Item Name" /></div><ol></ol></li>
                        --}}
                    </ol>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Sandy</h3>
                    </div>
                    <ol class='sortable-list user-container' data-user-id="3">
                        {{--
                        <li data-id="10"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="First2" placeholder="Enter Item Name" /></div><ol></ol></li>
                        <li data-id="11"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="Second2" placeholder="Enter Item Name" /></div><ol></ol></li>
                        <li data-id="12"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="Third2" placeholder="Enter Item Name" /></div><ol></ol></li>
                        <li data-id="13"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="Fourth2" placeholder="Enter Item Name" /></div><ol></ol></li>
                        <li data-id="14"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="Fifth2" placeholder="Enter Item Name" /></div><ol></ol></li>
                        <li data-id="15"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="Sixth2" placeholder="Enter Item Name" /></div><ol></ol></li>
                        <li data-id="16"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="Seventh2" placeholder="Enter Item Name" /></div><ol></ol></li>
                        <li data-id="17"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="Eigth2" placeholder="Enter Item Name" /></div><ol></ol></li>
                        <li data-id="18"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="Ninth2" placeholder="Enter Item Name" /></div><ol></ol></li>
                        --}}
                    </ol>
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
        var list_items = {!! $list_items !!};
    </script>
@endsection