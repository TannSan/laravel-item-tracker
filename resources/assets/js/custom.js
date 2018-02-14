
function updateSpecialization()
   {
      var options = [];

      switch($("select#advanced_class option:selected").val())
         {
            case "Assassin":
               options = ["Darkness", "Deception", "Hatred"];
               break;
            case "Juggernaut":
               options = ["Immortal", "Vengeance", "Rage"];
               break;
            case "Marauder":
               options = ["Annihilation", "Carnage", "Fury"];
               break;
            case "Mercenary":
               options = ["Arsenal", "Bodyguard", "Innovative Ordnance"];
               break;
            case "Operative":
               options = ["Concealment", "Lethality", "Medicine"];
               break;
            case "Powertech":
               options = ["Advanced Prototype", "Pyrotech", "Shield Tank"];
               break;
            case "Sniper":
               options = ["Engineering", "Marksmanship", "Virulance"];
               break;
            case "Sorcerer":
               options = ["Corruption", "Lightning", "Madness"];
               break;
         }

      var selected_option = $('select#specialization').data('selected');
      var output = "";
      for (var i = 0; i < 3; i++)
         {
            if(options[i] == selected_option)
               output += '<option value="' + options[i] + '" selected="selected">'+ options[i] +'</option>';
            else
               output += '<option value="' + options[i] + '">'+ options[i] +'</option>';
         }

      $('select#specialization').html(output);
   }

//$( document ).ready(function() {

   if ($('select#advanced_class').attr('data-selected'))
      $('select#advanced_class').val($('select#advanced_class').data('selected'));
   updateSpecialization();

   //  Wire up the Advanced Class select
   $("select#advanced_class").change(function() {
      updateSpecialization();
   });

   // Activate the DatePicker component
   $('input#parse_date').datepicker({
     autoclose: true,
     format:"yyyy-mm-dd"
   });
//});