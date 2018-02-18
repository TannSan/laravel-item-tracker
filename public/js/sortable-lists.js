function RemoteListItemCreated(e){if(e.user_id!=user_id){itemLog(e.user_name+" Created New Item");var t=$(list_item_template.replace(/#id#/,e.item_id).replace(/#title#/g,e.label));e.item_user_id>0?$('ol.user-container[data-user-id="'+e.item_user_id+'"]').append(t):$('li[data-id="'+e.parent_id+'"]').length?$('li[data-id="'+e.parent_id+'"]').children("ol").append(t):console.log(e.item_id+" Could Not Locate Parent "+e.parent_id+" For "+e.item_user_id),interactive||t.find("input").prop("disabled","disabled")}}function RemoteListItemSaved(e){if(e.user_id!=user_id){var t=$('li[data-id="'+e.item_id+'"]');if(e.label!=t.attr("data-label"))itemLog(e.user_name+" Renamed Item: "+t.attr("data-label")+" To: "+e.label),t.find("input").first().val(e.label),t.attr("data-label",e.label);else{var a;0==e.parent_id?(a=$('ol.user-container[data-user-id="'+e.item_user_id+'"]'))!=t.parent()&&(itemLog(e.user_name+" Moved An Item To Another User Panel"),t.appendTo(a)):(a=$('li[data-id="'+e.parent_id+'"]'))!=t.parent().parent()&&(itemLog(e.user_name+" Moved An Item"),t.appendTo(a.children("ol")))}}}function RemoteListItemDeleted(e){e.user_id!=user_id&&($kill_target=$('li[data-id="'+e.item_id+'"]'),itemLog(-1==e.item_ids.indexOf(",")?e.user_name+" Deleted An Item: "+$kill_target.attr("data-label"):e.user_name+" Deleted An Item: "+$kill_target.attr("data-label")+" (+Kids)"),$kill_target.remove())}function leadingZeros(e){return e<10?"0"+e:e}function itemLog(e){if(interactive){var t=new Date,a=leadingZeros(t.getHours())+":"+leadingZeros(t.getMinutes());item_log.val(item_log.val()+a+" "+e+"\n"),item_log.scrollTop(item_log[0].scrollHeight)}}function populateList(e){for(var t,a,i=0;e.length>0;)a=e[i],a.user_id>0?(t=$(list_item_template.replace(/#id#/,a.id).replace(/#title#/g,a.label)),$('ol.user-container[data-user-id="'+a.user_id+'"]').append(t),e.splice(i--,1)):$('li[data-id="'+a.parent_id+'"]').length&&(t=$(list_item_template.replace(/#id#/,a.id).replace(/#title#/g,a.label)),$('li[data-id="'+a.parent_id+'"]').children("ol").append(t),e.splice(i--,1)),++i==e.length&&(i=0)}function saveListItem(e){var t=e.closest("li");""!=e.val()&&e.val()!=t.attr("data-label")&&(itemLog("Renamed Item: "+t.attr("data-label")+" To: "+e.val()),t.attr("data-label",e.val()),$.ajax({method:"POST",url:"/list",context:t,data:{id:t.attr("data-id"),parent_id:getParentID(t),user_id:t.closest("ol.user-container").attr("data-user-id"),label:t.attr("data-label")},headers:{"X-CSRF-TOKEN":$("input[name=_token]").val()}}))}function getParentID(e){return e.parent().hasClass("user-container")?0:e.parent().parent().attr("data-id")}function listItemEnterKey(e){13==e.which&&(saveListItem($(this)),$(this).blur())}function listItemGainFocus(){"New Item"==$(this).val()&&$(this).val("")}function listItemLoseFocus(){""==$(this).val()&&$(this).val("New Item"),saveListItem($(this))}var pusher=new Pusher("b08d374d9d2bed6f5664",{auth:{headers:{"X-CSRF-Token":$("input[name=_token]").val()}},cluster:"eu",encrypted:!0}),channel=pusher.subscribe("list-demo");channel.bind("ListItemCreatedEvent",RemoteListItemCreated),channel.bind("ListItemSavedEvent",RemoteListItemSaved),channel.bind("ListItemDeletedEvent",RemoteListItemDeleted);var item_log=$("textarea#item-log");item_log.val(""),itemLog("Welcome!"),$("li#new-item input").val("New Item");var list_item_template='<li data-id="#id#" data-label="#title#"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="#title#" placeholder="Enter Item Name" /></div><ol></ol></li>';populateList(list_items),$("ol.user-container").sortable({group:"system-users",handle:"span.glyphicon-move",drag:interactive,drop:interactive,onDrop:function(e,t,a){if(a(e,t),t.el.hasClass("kill-container"))if("new-item"==e.attr("id"))$("ol.new-container").prepend(e),itemLog("Killed New Item");else{var i=e.find("li").map(function(){return $(this).attr("data-id")}).get();itemLog("Killed Item: "+e.attr("data-label")+(i.length>0?" (+Kids)":"")),$.ajax({method:"POST",url:"/list",context:e,data:{item_ids:e.attr("data-id")+","+i.join()},headers:{"X-CSRF-TOKEN":$("input[name=_token]").val()}}),e.remove()}else{if("new-item"==e.attr("id")){e.removeAttr("id"),$("input",e).prop("disabled",!1),$("input",e).focus(),e.append("<ol></ol>");var l=$("li#new-template").clone();l.attr("id","new-item"),l.prependTo("ol.new-container"),l.show(),itemLog("Created New Item")}var n=0;t.el.hasClass("user-container")||(n=t.el.parent().attr("data-id")),$.ajax({method:"POST",url:"/list",context:e,data:{id:e.attr("data-id"),parent_id:n,user_id:e.closest("ol.user-container").attr("data-user-id"),label:e.attr("data-label")},headers:{"X-CSRF-TOKEN":$("input[name=_token]").val()}}).done(function(e){0==$(this).attr("data-id")&&$(this).attr("data-id",e.id)})}return!1}}),$("ol.new-container").sortable({group:"system-users",drag:interactive,drop:!1,handle:"span.glyphicon-move"}),$("ol.kill-container").sortable({group:"system-users",drag:!1,drop:interactive}),$(document).on("keypress","ol.user-container input.form-control",listItemEnterKey),$(document).on("focusin","ol.user-container input.form-control",listItemGainFocus),$(document).on("focusout","ol.user-container input.form-control",listItemLoseFocus),interactive||$("div#app").find("input").prop("disabled","disabled");