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
function populateList(list_data) {
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

            // If this is the new-template list item then clone it back to the original position and then configure this copy
            if ($item.attr('id') == 'new-item') {
                $item.removeAttr('id');
                $('input', $item).prop("disabled", false);
                $('input', $item).focus();
                $item.append('<ol></ol>');

                // Clone the hidden template and display it so they can create another new list item
                var new_item = $('li#new-template').clone();
                new_item.attr('id', 'new-item');
                new_item.prependTo("ol.new-container");
                new_item.show();

            }

            // If the item is a direct descendant of a user container...
            var parent_id = 0;
            if (!container.el.hasClass('user-container')) {                
                parent_id = container.el.parent().data('id');
            }

            // Save the item to the database.  If it's a new item then retrieve and set the new ID.
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
                if($(this).data('id') == 0)
                    $(this).data('id', json_response.id);
                // itemLog(json_response);
            });

            _super($item, container);
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

// Track the panel that the dragged item was originally from so we can force a refresh on it after saving the changes
/*
$("ol.user-container").mousedown(function (event) {
    console.log('Source Panel User ID: ' + $(this).data('user-id'));
    //event.preventDefault();
    //return true;
});
*/

/**
 * Save the list item to the database.  This is called when the label is changed.
 * @param {JQuery object for the list item Text Input} target 
 */
function saveListItem(target) {
    var target_li = target.closest('li');
    if (target.val() != "" && target.val() != target_li.data('label'))
        {
            target_li.data('label', target.val());
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
        return target.parent().parent().data('id');

    return 0;
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