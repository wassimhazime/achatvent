
$(document).ready(function() {
            var table = $('#example');
    function hide_row(elem) {

         var row = elem.parents("tr");
        if (row.hasClass("child")) {
         table.DataTable().row(row.prev()).remove().draw( false );
        }else {
             table.DataTable().row(row).remove().draw( false );
        }

    }
    table.on("click", ".supprimer", function(e) {
       e.preventDefault();
        var elem = $(this);
        var url = (elem.data("urlsup"));
        hide_row(elem);
        var ajax = new XMLHttpRequest();
        ajax.addEventListener("load", function() {
        }, false);
        ajax.open("GET", url);
        ajax.send();
    })

});
