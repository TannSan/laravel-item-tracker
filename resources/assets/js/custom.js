
var item_log = $('textarea#item-log');
function leadingZeros(message_time)
    {
        return message_time < 10 ? '0' + message_time : message_time;
    }

function itemLog(message)
    {
        var dt = new Date();
        var message_time = leadingZeros(dt.getHours()) + ":" + leadingZeros(dt.getMinutes());
        item_log.val(item_log.val() + '\n' + message_time + ' ' + message);
        item_log.scrollTop(item_log[0].scrollHeight);
    }

$("ol.user-container").sortable(
    {
        group: 'system-users',
        handle: 'span.glyphicon-move',
        onDrop: function ($item, container, _super) {

            /**
             *  If this is the new-template list item then clone it back to the original position and then configure this copy
             */
            if($item.attr('id') == 'new-item')
                {
                    $item.removeAttr('id');
                    $('input', $item).prop("disabled", false);
                    $item.append('<ol></ol>');

                    var new_item = $('li#new-template').clone();
                    new_item.attr('id', 'new-item');
                    new_item.prependTo("ol.new-container");
                    new_item.show();
                }

            $.ajax({
                method: 'POST',
                url: '/list',
                data: {
                    'testsend': 'somedata'
                },
                headers: { 'X-CSRF-TOKEN': $('input[name=_token]').val() }
            }).done(function (json_response) {
                $("div.alert-success").html(json_response.test);
                console.log(json_response);
                itemLog(json_response);
            });
            _super($item, container);
            return false;
        }
    }
);

$("ol.new-container").sortable(
    {
        group: 'system-users',
        drop: false,
        handle: 'span.glyphicon-move',
        onDrop: function ($item, container, _super) {
            console.log("Dropped");
            _super($item, container);
            return false;
        }
    }
);