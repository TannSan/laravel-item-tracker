function leadingZeros(e){return e<10?"0"+e:e}function itemLog(e){var t=new Date,a=leadingZeros(t.getHours())+":"+leadingZeros(t.getMinutes());item_log.val(item_log.val()+a+" "+e+"\n"),item_log.scrollTop(item_log[0].scrollHeight)}function populateList(e){for(var t,a,i=0;e.length>0;)a=e[i],a.user_id>0?(t=$(list_item_template.replace(/#id#/,a.id).replace(/#title#/g,a.label)),$('ol.user-container[data-user-id="'+a.user_id+'"]').append(t),e.splice(i--,1)):$('li[data-id="'+a.parent_id+'"]').length&&(t=$(list_item_template.replace(/#id#/,a.id).replace(/#title#/g,a.label)),$('li[data-id="'+a.parent_id+'"]').children("ol").append(t),e.splice(i--,1)),++i==e.length&&(i=0)}function saveListItem(e){var t=e.closest("li");""!=e.val()&&e.val()!=t.data("label")&&(itemLog("Renamed Item: "+t.data("label")+" To: "+e.val()),t.data("label",e.val()),$.ajax({method:"POST",url:"/list",context:t,data:{id:t.data("id"),parent_id:getParentID(t),user_id:t.closest("ol.user-container").data("user-id"),label:t.data("label")},headers:{"X-CSRF-TOKEN":$("input[name=_token]").val()}}))}function getParentID(e){return e.parent().hasClass("user-container")?0:e.parent().parent().data("id")}function listItemEnterKey(e){13==e.which&&(saveListItem($(this)),$(this).blur())}function listItemGainFocus(){"New Item"==$(this).val()&&$(this).val("")}function listItemLoseFocus(){""==$(this).val()&&$(this).val("New Item"),saveListItem($(this))}var item_log=$("textarea#item-log");item_log.val(""),itemLog("Welcome!"),$("li#new-item input").val("New Item");var list_item_template='<li data-id="#id#" data-label="#title#"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="#title#" placeholder="Enter Item Name" /></div><ol></ol></li>';populateList(list_items),$("ol.user-container").sortable({group:"system-users",handle:"span.glyphicon-move",onDrop:function(e,t,a){if(a(e,t),t.el.hasClass("kill-container")){if("new-item"!=e.attr("id")){var i=e.find("li").map(function(){return $(this).data("id")}).get();itemLog("Killed Item: "+e.data("label")+(i.length>0?" (+Kids)":"")),$.ajax({method:"POST",url:"/list",context:e,data:{item_ids:e.data("id")+","+i.join()},headers:{"X-CSRF-TOKEN":$("input[name=_token]").val()}})}else itemLog("Killed New Item");e.remove()}else{if("new-item"==e.attr("id")){e.removeAttr("id"),$("input",e).prop("disabled",!1),$("input",e).focus(),e.append("<ol></ol>");var l=$("li#new-template").clone();l.attr("id","new-item"),l.prependTo("ol.new-container"),l.show(),itemLog("Created New Item")}var n=0;t.el.hasClass("user-container")||(n=t.el.parent().data("id")),$.ajax({method:"POST",url:"/list",context:e,data:{id:e.data("id"),parent_id:n,user_id:e.closest("ol.user-container").data("user-id"),label:e.data("label")},headers:{"X-CSRF-TOKEN":$("input[name=_token]").val()}}).done(function(e){0==$(this).data("id")&&$(this).data("id",e.id)})}return!1}}),$("ol.new-container").sortable({group:"system-users",drop:!1,handle:"span.glyphicon-move"}),$("ol.kill-container").sortable({group:"system-users",drag:!1}),$(document).on("keypress","ol.user-container input.form-control",listItemEnterKey),$(document).on("focusin","ol.user-container input.form-control",listItemGainFocus),$(document).on("focusout","ol.user-container input.form-control",listItemLoseFocus);