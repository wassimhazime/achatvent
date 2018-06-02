
$(document).ready(function() {

    var table = $('#DataTableJs');
    var ajax_sup = function(url, row) {
        $.get(url)
         .done( function(data) {
            $.alert({
                icon: 'glyphicon glyphicon-ok',
                closeIcon: true,
                type: 'green',
                title: 'message!',
                content: data,
            });
            hide_row(row);
        })
         .fail(function(data) {
            $.alert({
                icon: 'glyphicon glyphicon-warning-sign',
                closeIcon: true,
                type: 'red',
                title: 'message!',
                content: data.responseText,
            });
        });
    };
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
    var traitement_sup = function(urlmessage, urlsup, row) {
        $.get(urlmessage).done(
        function(data) {
            $.confirm({
                closeIcon: true,
                backgroundDismiss: false,
                backgroundDismissAnimation: 'glow',
                columnClass: 'col-md-12',
                icon: 'fa fa-spinner fa-spin',
                title: ' Faut-il vraiment supprimer les donnees!',
                content: data,
                type: 'red',
                typeAnimated: true,
                buttons: {
                    confirm: function() {
                        ajax_sup(urlsup, row);
                    },
                    cancel: function() {
                    }
                }
            });
        });
    }

    table.on("click", ".supprimer", function(e) {
        e.preventDefault();
        var elem = $(this);
        var urlsup = elem.data("urlsup");
        var urlmessage = elem.data("urlmessage");
        var row = get_row(elem);
        traitement_sup(urlmessage, urlsup, row);
    })

});
