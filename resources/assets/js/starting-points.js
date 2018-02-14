// Handle the delete button confirmation click
$('[data-toggle=confirmation]').confirmation({
   rootSelector: '[data-toggle=confirmation]',
   onConfirm: function() {
      $.ajax({
            method: "DELETE",
            url: "/parse/"+$("select#delete_parse_id option:selected").val(),
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()}
         }).always(function() {
         location.reload(true);
      });
      return false;
   }
});

if ($("div.alert-success").length)
   {
      $("div.alert-success").fadeTo(2000, 500).slideUp(500, function(){
         $("div.alert-success").remove();
      });
   }