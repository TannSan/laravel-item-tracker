/**
 * Item List Mechanics
 * Author: David Millington
 */

// Reset the new item text to avoid caching issue
$('li#new-item input').val('New Item');

// Setup our action log
var item_log = $('textarea#item-log');

/**
 * Adds leading zeros to time values if needed.
 * @param {int} message_time 
 */
function leadingZeros(message_time) {
    return message_time < 10 ? '0' + message_time : message_time;
}

/**
 * Writes to the action log.
 * @param {string} message 
 */
function itemLog(message) {
    var dt = new Date();
    var message_time = leadingZeros(dt.getHours()) + ":" + leadingZeros(dt.getMinutes());    
    item_log.val(item_log.val() + message_time + ' ' + message + '\n');
    item_log.scrollTop(item_log[0].scrollHeight);
}

// Initialise the action log.
item_log.val('');
itemLog('Welcome!');

function getParentID(target)
{
    if(!target.parent().hasClass('user-container'))
        return target.parent().parent().data('id');

    return 0;
}

// This is the template that is used when we create list items via AJAX calls.  It uses ## values which are string replaced later on
var list_item_template = '<li data-id="#id#" data-label="#title#"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="#title#" placeholder="Enter Item Name" /></div></li>';

/**
 * Populates a sorted list with items.
 * @param {JQuery object for a list} target_list 
 * @param {JSON} list_data 
 */
function populateList(target_list, list_data) {
    var children;
    var new_list_item;
    var new_list_item_child_list;
    $.each(list_data[0], function (index) {
        // Create and attach new list item
        new_list_item = $(list_item_template.replace(/#id#/, list_data[0][index].id).replace(/#title#/g, 'Item' + list_data[0][index].id));
        target_list.append(new_list_item);

        // Create and attach new list item child list
        new_list_item_child_list = $('<ol></ol>');
        new_list_item.append(new_list_item_child_list);

        // Recurse into children (if any)
        children = list_data[0][index].children;
        if (children[0].length > 0)
            populateList(new_list_item_child_list, children);
    });
}
populateList($('ol.user-container[data-user-id="2"]'), [[{ "id": 1, "children": [[]] }, { "id": 2, "children": [[]] }, { "id": 3, "children": [[]] }, { "id": 4, "children": [[{ "id": 25, "children": [[{ "id": 35, "children": [[]] }, { "id": 55, "children": [[]] }]] }]] }, { "id": 5, "children": [[]] }, { "id": 6, "children": [[]] }, { "id": 7, "children": [[]] }, { "id": 8, "children": [[]] }]]);

// Setup the sortable list components
$("ol.user-container").sortable(
    {
        group: 'system-users',
        handle: 'span.glyphicon-move',
        onDrop: function ($item, container, _super) {

            // If this is the new-template list item then clone it back to the original position and then configure this copy
            if ($item.attr('id') == 'new-item') {
                $item.removeAttr('id');
                $('input', $item).prop("disabled", false);
                // $('input', $item).val('');
                $('input', $item).focus();
                $item.append('<ol></ol>');

                // Clone the hidden template and display it so they can create another new list item
                var new_item = $('li#new-template').clone();
                new_item.attr('id', 'new-item');
                new_item.prependTo("ol.new-container");
                new_item.show();

                // TODO: Save a new item to the database, retrieve the new ID and set the attribute
            }

            /**
             * Post the updated item position to the controller
             */
            /*
            console.log("Container:");
            console.log(container);
            console.log("Item:");
            console.log($item);
            */

            // If the item is a direct descendant of a user container...
            var parent_id = 0;
            if (container.el.hasClass('user-container')) {
                console.log("Direct Descendant");
            }
            else {
                console.log("Child Of: " + container.el.parent().data('id'));
                parent_id = container.el.parent().data('id');
            }

            // console.log(JSON.stringify(container.serialize()));

            /*
            $data = $request->validate([
                'parent_id' => 'required|numeric',
                'user_id' => 'required|numeric',
                'label' => 'required|max:256'
            ]);
            <ol class='sortable-list user-container' data-user-id="3">
            */

            console.log("Item Label: " + $('input', $item).val());
            $.ajax({
                method: 'POST',
                url: '/list',
                context: $item,
                data: {
                    'id': $item.data('id'),
                    'parent_id': parent_id,
                    'user_id': $item.closest('ol.user-container').data('user-id'),
                    'label': $item.data('label')
                },
                headers: { 'X-CSRF-TOKEN': $('input[name=_token]').val() }
            }).done(function (json_response) {
                // $("div.alert-success").html(json_response.test);
                console.log("AJAX Response:");
                console.log(json_response);
                console.log($(this));
                if($(this).data('id') == 0)
                    $(this).data('id', json_response.id);
                // itemLog(json_response);
            });

            _super($item, container);
            return false;
        }
    }
);

// Track the panel that the dragged item was originally from so we can force a refresh on it after saving the changes
var source_panel_list;
$("ol.user-container").mousedown(function (event) {
    console.log('Source Panel User ID: ' + $(this).data('user-id'));
    //event.preventDefault();
    //return true;
});

// Setup the New Item panel
$("ol.new-container").sortable(
    {
        group: 'system-users',
        drop: false,
        handle: 'span.glyphicon-move'
    }
);

/**
 * Save the list item to the database.
 * @param {JQuery object for the list item Text Input} target 
 */
function saveListItem(target) {
    var target_li = target.closest('li');
    if (target.val() != "" && target.val() != target_li.data('label'))
        {
            target_li.data('label', target.val())
            console.log("Saving: " + target.val());
            console.log("Parent ID: " + getParentID(target_li));
            $.ajax({
                method: 'POST',
                url: '/list',
                context: target_li,
                data: {
                    'id': target_li.data('id'),
                    'parent_id': getParentID(target_li),
                    'user_id': target_li.closest('ol.user-container').data('user-id'),
                    'label': target_li.data('label')
                },
                headers: { 'X-CSRF-TOKEN': $('input[name=_token]').val() }
            }).done(function (json_response) {
                // $("div.alert-success").html(json_response.test);
                console.log("AJAX Response B:");
                console.log(json_response);
                console.log($(this));
                if($(this).data('id') == 0)
                    {
                        //$(this).data('id', json_response.id);
                        //$('input', $(this)).val('Item' + json_response.id);
                    }
                // itemLog(json_response);
            });
        }        
}

/**
 * Save the changes when enter is pressed within one of the text inputs or when it loses focus.
 */
function listItemEnterKey(event) {
    if (event.which == 13) {
        saveListItem($(this));
        $(this).blur();
    }
}

function listItemGainFocus() {
    if($(this).val() == "New Item")
        $(this).val("");
}

function listItemLoseFocus() {
    if($(this).val() == "")
        $(this).val("New Item");

    saveListItem($(this));
}

// Attach the enter keypress and focus events to the document so they also apply to items dynamically created later on, also avoids associating tons of event listeners.
$(document).on('keypress', 'ol.user-container input.form-control', listItemEnterKey);
$(document).on('focusin', 'ol.user-container input.form-control', listItemGainFocus);
$(document).on('focusout', 'ol.user-container input.form-control', listItemLoseFocus);

// Test re-activing a list when it is changed after the original init
// populateList($('ol.user-container[data-user-id="3"]'),  [[{"id":1,"children":[[]]},{"id":2,"children":[[]]},{"id":3,"children":[[]]},{"id":4,"children":[[{"id":25,"children":[[{"id":35,"children":[[]]}, {"id":55,"children":[[]]}]]}]]},{"id":5,"children":[[]]},{"id":6,"children":[[]]},{"id":7,"children":[[]]},{"id":8,"children":[[]]}]]);


// Fetch Test Data
//console.log(JSON.stringify($('ol.user-container[data-user-id="2"]').sortable("serialize").get()));
//console.log(JSON.stringify($('ol.user-container[data-user-id="3"]').sortable("serialize").get()));