"use strict";
/**
 * voir table par json 
 */


function DataTableJson(id, datajson, optiondatatable, routes) {
    
    function generateUri(id, routes) {
        var urlarray = routes.replace(/0/g, id).split("~");
        var urlobject = {};

        for (var i = 0; i < urlarray.length; i++) {
            var url = urlarray[i].split("|");
            urlobject[url[0]] = url[1];
        }
        return urlobject;
    }

    function generateControleInput(urlobject) {
        var $message = urlobject["urlmessage"];
        var $supprimer = urlobject["urlsupprimer"];
        var $modifier = urlobject["urlmodifier"];
        var $voir = urlobject["urlvoir"];
        return   '<spam style="display: block;margin: auto;width: 15px;;    width: max-content;">'
                + '<button class="btn btn-danger   supprimer" data-urlmessage="' + $message + '"   data-urlsup="' + $supprimer + '" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'
                + '<a class="btn btn-success  modifier"    href="' + $modifier + '" ><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>'
                + '<a class="btn btn-primary  voir"    href="' + $voir + '" ><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>'
                + '</spam>'
    }

    var bt1 = {
        text: 'My button',
        className: 'btn btn-primary',
        action: function(e, dt, node, config) {
            alert(this.text());
        }
    };
    var bt2 = {
        text: 'Get selected data',
        action: function() {
            var count = table.rows({selected: true}).count();
            console.log(table.rows({selected: true}).data().toArray());
            ;
        }
    }
    var param = {};
    
    var columns = datajson["titles"];
    columns.push({title: '<i class="glyphicon glyphicon-edit  " style="color:#3665B0;display: block;margin: auto;width: 15px;"></i>'});
    columns.unshift({title: '<span class="glyphicon glyphicon-check" aria-hidden="true" style="    display: block;margin: auto;width: 15px;"></span>'});
    param.columns = columns;

    var data = datajson["dataSet"];
    for (var i = 0; i < data.length; i++) {
        var id_row = data[i][0];
        var urlobject = generateUri(id_row, routes);
        var input_control = generateControleInput(urlobject);
        data[i].push(input_control); // input control sup modi voir
        data[i].unshift(" ");  // add checkbox 
    }
    param.data = data;




    param.columnDefs = [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0
        }]
    param.select = {
        style: 'multi',
        // style: 'os',
        selector: 'td:first-child'
    }
    param.order = [[1, 'asc']]
    param.lengthMenu = [
        [10, 25, 50, -1],
        ['10 éléments', '25 éléments', '50 éléments', 'tous éléments']
    ];





    param.dom = 'Bfrtip';

    param.buttons = [
        optiondatatable.split(" "),
        bt1,
        bt2
    ];
    param.lengthChange = false;

    param.language = {
        processing: "Traitement en cours...",
        search: "Rechercher&nbsp;:",
        lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
        info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
        infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
        infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        infoPostFix: "",
        loadingRecords: "Chargement en cours...",
        zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
        emptyTable: "Aucune donnée disponible dans le tableau",
        paginate: {
            first: "Premier",
            previous: "Pr&eacute;c&eacute;dent",
            next: "Suivant",
            last: "Dernier"
        },
        aria: {
            sortAscending: ": activer pour trier la colonne par ordre croissant",
            sortDescending: ": activer pour trier la colonne par ordre décroissant"
        }
        , buttons: {
            colvis: "select les champs"
        },
        select: {
            rows: {
                _: "rak %d rows",
                0: "Click a row to hna it",
                1: "rir 1 row selected"
            }
        }
    }

    var table = $(id).DataTable(param);
}