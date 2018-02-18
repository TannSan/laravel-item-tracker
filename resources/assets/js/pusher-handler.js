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