/**
 * Pusher Remote Activity Functionality
 * Author: David Millington
 */

/*
// Really useful for debugging purposes
Pusher.log = function(msg)
    {
        console.log(msg);
    };
*/
var pusher = new Pusher("b08d374d9d2bed6f5664", { 
    /*authEndpoint: '/pusher/auth',*/
    auth: {
        headers: {
            'X-CSRF-Token': $('input[name=_token]').val()
        }
    },
    cluster: 'eu',
    encrypted: true 
}); 

/**
  * Handles new List Items being created by a remote user.
  * Called when the broadcast "Created" event is received.
  * @param {Object} data 
 */
function RemoteListItemCreated(data)
    {
        // Don't process messages sent by yourself!
        if(data.user_id != user_id)
            {
                itemLog(data.user_name + ' Created New Item');
                var new_list_item = $(list_item_template.replace(/#id#/, data.item_id).replace(/#title#/g, data.label));

                // If it's a top level node then attach it to the correct panel.
                if(data.item_user_id > 0)
                    $('ol.user-container[data-user-id="' + data.item_user_id + '"]').append(new_list_item);
                // Else it's a child node so attach to the correct item (if it exists).
                else if ($('li[data-id="' + data.parent_id + '"]').length)
                    $('li[data-id="' + data.parent_id + '"]').children('ol').append(new_list_item);
                else
                    console.log(data.item_id + ' Could Not Locate Parent ' + data.parent_id + ' For ' + data.item_user_id);
            }
    }

/**
     * Handles changing the parent or label of an existing List Item by a remote user.
     * Called when the broadcast "Saved" event is received.
     * @param {Object} data 
 */
function RemoteListItemSaved(data)
    {
        // Don't process messages sent by yourself!
        if(data.user_id != user_id)
            {
                var changed_item = $('li[data-id="' + data.item_id + '"]');

                // If the item was renamed...
                if (data.label != changed_item.attr('data-label'))
                    {
                        itemLog(data.user_name + ' Renamed Item: ' + changed_item.attr('data-label') + ' To: ' + data.label); 
                        changed_item.find('input').first().val(data.label);
                        changed_item.attr('data-label', data.label);
                    }
                else
                    {                    
                        var target_parent;
                        // If the item is connected to a user panel.
                        if(data.parent_id == 0)
                            {
                                target_parent = $('ol.user-container[data-user-id="' + data.item_user_id + '"]');
                                if(target_parent != changed_item.parent())
                                    {
                                        // The remote item has been moved so move the local copy
                                        itemLog(data.user_name + ' Moved An Item To Another User Panel'); 
                                        changed_item.appendTo(target_parent);
                                    } 
                            }
                        // Else it is connected to another list item.
                        else
                            {
                                target_parent = $('li[data-id="' + data.parent_id + '"]');
                                if(target_parent != changed_item.parent().parent())
                                    {
                                        // The remote item has been moved so move the local copy
                                        itemLog(data.user_name + ' Moved An Item'); 
                                        changed_item.appendTo(target_parent.children('ol'));
                                    }
                            }
                    }
            }
    }

/**
     * Handles new List Items being deleted by a remote user.
     * Called when the broadcast "Delete" event is received.
     * @param {Object} data 
 */
function RemoteListItemDeleted(data)
    {
        // Don't process messages sent by yourself!
        if(data.user_id != user_id)
            {
                $kill_target = $('li[data-id="' + data.item_id + '"]');

                if(data.item_ids.indexOf(',') == -1)
                    itemLog(data.user_name + ' Deleted An Item: ' + $kill_target.attr('data-label'));
                else
                    itemLog(data.user_name + ' Deleted An Item: ' + $kill_target.attr('data-label') + ' (+Kids)');

                $kill_target.remove();
            }
    }

var channel = pusher.subscribe('list-demo');
channel.bind('ListItemCreatedEvent', RemoteListItemCreated);
channel.bind('ListItemSavedEvent', RemoteListItemSaved);
channel.bind('ListItemDeletedEvent', RemoteListItemDeleted);
/**
 * User Log
 * Author: David Millington
 */

var item_log = $('textarea#item-log');
item_log.val('');

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
itemLog('Welcome!');
/**
 * Item List Mechanics
 * Author: David Millington
 */

// Reset the new item text to avoid caching issue.
$('li#new-item input').val('New Item');

// This is the template that is used when we create list items via AJAX calls.  It uses ## values which are string replaced later on.
var list_item_template = '<li data-id="#id#" data-label="#title#"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="#title#" placeholder="Enter Item Name" /></div><ol></ol></li>';

/**
 * Creates all the list items using the provided item list data (in a flat structure).
 * @param {JSON} list_data 
 */
function populateList(list_data)
    {
        var new_list_item;
        var current_item_data;
        var index = 0;
        while(list_data.length > 0)
            {
                current_item_data = list_data[index];
                if(current_item_data.user_id > 0)
                    {
                        // If it's a top level node then attach it to the correct panel.
                        new_list_item = $(list_item_template.replace(/#id#/, current_item_data.id).replace(/#title#/g, current_item_data.label));
                        $('ol.user-container[data-user-id="' + current_item_data.user_id + '"]').append(new_list_item);
                        list_data.splice(index--, 1);
                    }
                else
                    {
                        // Else it's a child node so attach to the correct item (if it exists yet).
                        if ($('li[data-id="' + current_item_data.parent_id + '"]').length)
                            {
                                new_list_item = $(list_item_template.replace(/#id#/, current_item_data.id).replace(/#title#/g, current_item_data.label));
                                $('li[data-id="' + current_item_data.parent_id + '"]').children('ol').append(new_list_item);
                                list_data.splice(index--, 1);
                            }
                    }

                if(++index == list_data.length)
                    index = 0;
            }
    }
populateList(list_items);

/**
 * Initialise the sortable list components.
 */
$("ol.user-container").sortable(
    {
        group: 'system-users',
        handle: 'span.glyphicon-move',
        onDrop: function ($item, container, _super) {
            _super($item, container);

            /**
             * There seems to be a bug with the sortable list component were the onDrop function only works for the first .sortable initialisation.
             * So if I define another onDrop inside the $("ol.kill-container").sortable() it never gets called.
             * Because of that I have lumped the kill behavior in here.
             */
            if(container.el.hasClass('kill-container'))
                { 
                    // Delete the item and it's children in the database.   
                    // Hijacking the POST (/store) route so we can send custom variables
                    if ($item.attr('id') == "new-item")
                        {
                            // We don't delete the New Item, we just move it back to the New Item panel.
                            $('ol.new-container').prepend($item);
                            itemLog('Killed New Item'); 
                        }
                    else
                        {   
                            var id_array = $item.find("li").map(function() { return $(this).attr('data-id'); }).get();                            
                            itemLog('Killed Item: ' + $item.attr('data-label') + (id_array.length > 0 ? ' (+Kids)' : '')); 
                            $.ajax({
                                method: 'POST',
                                url: '/list',
                                context: $item,
                                data: {
                                    'item_ids': $item.attr('data-id') + ',' + id_array.join()
                                },
                                headers: { 'X-CSRF-TOKEN': $('input[name=_token]').val() }
                            });                                           
                            $item.remove();
                        }    
                }
            else
                {
                    // If this is the new-template list item then clone it back to the original position and then configure this copy
                    if ($item.attr('id') == 'new-item')
                        {
                            $item.removeAttr('id');
                            $('input', $item).prop("disabled", false);
                            $('input', $item).focus();
                            $item.append('<ol></ol>');

                            // Clone the hidden template and display it so they can create another new list item
                            var new_item = $('li#new-template').clone();
                            new_item.attr('id', 'new-item');
                            new_item.prependTo("ol.new-container");
                            new_item.show();
                            
                            itemLog('Created New Item');  
                        }

                    // If the item is a direct descendant of a user container...
                    var parent_id = 0;
                    if (!container.el.hasClass('user-container'))
                        parent_id = container.el.parent().attr('data-id');

                    // Save the item to the database.  If it's a new item then retrieve and set the new ID.
                    $.ajax({
                        method: 'POST',
                        url: '/list',
                        context: $item,
                        data: {
                            'id': $item.attr('data-id'),
                            'parent_id': parent_id,
                            'user_id': $item.closest('ol.user-container').attr('data-user-id'),
                            'label': $item.attr('data-label')
                        },
                        headers: { 'X-CSRF-TOKEN': $('input[name=_token]').val() }
                    }).done(function (json_response) {
                        if($(this).attr('data-id') == 0)
                            $(this).attr('data-id', json_response.id);
                    });
                }

            return false;
        }
    }
);

// Initialise the New Item panel.
$("ol.new-container").sortable(
    {
        group: 'system-users',
        drop: false,
        handle: 'span.glyphicon-move'
    }
);

// Initialise the Kill Item panel.
$("ol.kill-container").sortable(
    {
        group: 'system-users',
        drag: false
    }
);

// Track the panel that the dragged item was originally from so we can force a refresh on it after saving the changes
/*
$("ol.user-container").mousedown(function (event) {
    console.log('Source Panel User ID: ' + $(this).attr('data-user-id'));
    //event.preventDefault();
    //return true;
});
*/

/**
 * Save the list item to the database.  This is called when the label is changed.
 * @param {JQuery object for the list item Text Input} target 
 */
function saveListItem(target)
    {
        var target_li = target.closest('li');
        if (target.val() != "" && target.val() != target_li.attr('data-label'))
            {
                itemLog('Renamed Item: ' + target_li.attr('data-label') + ' To: ' + target.val()); 

                target_li.attr('data-label', target.val());
                $.ajax({
                    method: 'POST',
                    url: '/list',
                    context: target_li,
                    data: {
                        'id': target_li.attr('data-id'),
                        'parent_id': getParentID(target_li),
                        'user_id': target_li.closest('ol.user-container').attr('data-user-id'),
                        'label': target_li.attr('data-label')
                    },
                    headers: { 'X-CSRF-TOKEN': $('input[name=_token]').val() }
                });
            }        
    }

/**
 * Returns the data-id of the ListItem that is the parent of the supplied target or 0 if the parent is a user panel.
 * @param {List Item} target 
 */
function getParentID(target)
    {
        if(!target.parent().hasClass('user-container'))
            return target.parent().parent().attr('data-id');

        return 0;
    }

/**
 * Save the changes when enter is pressed within one of the text inputs or when it loses focus.
 */
function listItemEnterKey(event)
    {
        if (event.which == 13)
            {
                saveListItem($(this));
                $(this).blur();
            }
    }

function listItemGainFocus()
    {
        if($(this).val() == "New Item")
            $(this).val("");
    }

function listItemLoseFocus()
    {
        if($(this).val() == "")
            $(this).val("New Item");

        saveListItem($(this));
    }

// Attach the enter keypress and focus events to the document so they also apply to items dynamically created later on, also avoids associating tons of event listeners.
$(document).on('keypress', 'ol.user-container input.form-control', listItemEnterKey);
$(document).on('focusin', 'ol.user-container input.form-control', listItemGainFocus);
$(document).on('focusout', 'ol.user-container input.form-control', listItemLoseFocus);