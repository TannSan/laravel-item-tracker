!function(e){var t={};function n(a){if(t[a])return t[a].exports;var i=t[a]={i:a,l:!1,exports:{}};return e[a].call(i.exports,i,i.exports,n),i.l=!0,i.exports}n.m=e,n.c=t,n.d=function(e,t,a){n.o(e,t)||Object.defineProperty(e,t,{configurable:!1,enumerable:!0,get:a})},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=3)}({3:function(e,t,n){e.exports=n("4fB0")},"4fB0":function(e,t){$("li#new-item input").val("New Item");var n='<li data-id="#id#" data-label="#title#"><div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-move"></span></span><input type="text" class="form-control" value="#title#" placeholder="Enter Item Name" /></div><ol></ol></li>';function a(e){var t,n=e.closest("li");""!=e.val()&&e.val()!=n.data("label")&&(n.data("label",e.val()),$.ajax({method:"POST",url:"/list",context:n,data:{id:n.data("id"),parent_id:(t=n,t.parent().hasClass("user-container")?0:t.parent().parent().data("id")),user_id:n.closest("ol.user-container").data("user-id"),label:n.data("label")},headers:{"X-CSRF-TOKEN":$("input[name=_token]").val()}}))}!function(e){for(var t,a,i=0;e.length>0;)(a=e[i]).user_id>0?(t=$(n.replace(/#id#/,a.id).replace(/#title#/g,a.label)),$('ol.user-container[data-user-id="'+a.user_id+'"]').append(t),e.splice(i--,1)):$('li[data-id="'+a.parent_id+'"]').length&&(t=$(n.replace(/#id#/,a.id).replace(/#title#/g,a.label)),$('li[data-id="'+a.parent_id+'"]').children("ol").append(t),e.splice(i--,1)),++i==e.length&&(i=0)}(list_items),$("ol.user-container").sortable({group:"system-users",handle:"span.glyphicon-move",onDrop:function(e,t,n){if("new-item"==e.attr("id")){e.removeAttr("id"),$("input",e).prop("disabled",!1),$("input",e).focus(),e.append("<ol></ol>");var a=$("li#new-template").clone();a.attr("id","new-item"),a.prependTo("ol.new-container"),a.show()}var i=0;return t.el.hasClass("user-container")||(i=t.el.parent().data("id")),$.ajax({method:"POST",url:"/list",context:e,data:{id:e.data("id"),parent_id:i,user_id:e.closest("ol.user-container").data("user-id"),label:e.data("label")},headers:{"X-CSRF-TOKEN":$("input[name=_token]").val()}}).done(function(e){0==$(this).data("id")&&$(this).data("id",e.id)}),n(e,t),!1}}),$("ol.new-container").sortable({group:"system-users",drop:!1,handle:"span.glyphicon-move"}),$(document).on("keypress","ol.user-container input.form-control",function(e){13==e.which&&(a($(this)),$(this).blur())}),$(document).on("focusin","ol.user-container input.form-control",function(){"New Item"==$(this).val()&&$(this).val("")}),$(document).on("focusout","ol.user-container input.form-control",function(){""==$(this).val()&&$(this).val("New Item"),a($(this))})}});