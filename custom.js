$(document).ready( function() {
/*
    var json = (function () {
        var json = null;
        $.ajax({
            'async': false,
            'global': false,
            'url': ajaxscript.templatedir,
            'dataType': "json",
            'success': function (data) {
                json = data;
            }
        });
        return json;
    })(); 
    autoComplete = [];

    for (var i = 0, len = json.length; i < len; i++) {

        autoComplete.push("" + json[i]["cp"] + " " + json[i]["ville"]);
    }
    ( function( $ ) {

        $( "#billing_postcode" ).autocomplete({
          source: autoComplete,
          maxHeight: 200, //you could easily change this maxHeight value
          minLength: 4,
          delay: 1000, // optional > this will allow a wait time of 1 sec between each keys before executing
          select: function (event, ui) {
            ville = ui.item.label.replace(/[0-9]/g, '');
            cp = ui.item.value.replace(/\D/g,'');
            $( "#billing_postcode" ).val(cp);
            $('#billing_city').val(ville);
            jQuery('body').trigger('update_checkout');
            return false;
          }
        // On remplit aussi la ville

        });

        $( "#billing_postcode" ).on( "autocompleteselect", function( event, ui ) {
            jQuery('body').trigger('update_checkout');
            return false;
        } );
    } )( jQuery );
*/
});
