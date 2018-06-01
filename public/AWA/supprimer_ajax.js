
$(document).ready(function() {
    var table = $('#example');
    var hide_row = function(row) {
        table.DataTable().row(row).remove().draw(false);
    }
    var get_row = function(elem) {
        var row = elem.parents("tr");
        if (row.hasClass("child")) {
            row = elem.parents("tr").prev();
        }
        return row;
    }
    var get_data = function(row) {

        row.find("td").each(function(index) {
            console.log(index + ": " + $(this).text());
        });
        ;
    }
    var ajax = function(url) {
        var ajax = new XMLHttpRequest();
        ajax.addEventListener("load", function() {
        }, false);
        ajax.open("GET", url);
        ajax.send();
    };
    table.on("click", ".supprimer", function(e) {
        e.preventDefault();
        var elem = $(this);
        var url = (elem.data("urlsup"));
        var row = get_row(elem);
        var data = get_data(row);
        var confirmation = window.confirm(" supprimer message ")
        if (confirmation) {
            hide_row(row);
            ajax(url)
        }

    })

});
