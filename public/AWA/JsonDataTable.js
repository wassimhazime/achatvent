"use strict";
/**
 * voir table par json 
 */
function generateUri(id, routes) {
    var urlarray = routes.replace(/0/g, id).split("~");
    var urlobject = {};

    for (var i = 0; i < urlarray.length; i++) {
        var url = urlarray[i].split("|");
        urlobject[url[0]] = url[1];
    }
    return urlobject;
}

function DataTableJson(id, datajson, optiondatatable, routes) {
    console.log(generateUri(3, routes));

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
    
    columns.push({title: '<i class="glyphicon glyphicon-th-list " style="font-size:35px ; color:#3665B0"></i>'});
    param.columns=columns;
    
    var data = datajson["dataSet"];
    for (var i = 0; i < data.length; i++) {
       data[i].push("<a href='/'>xxx</a>") ;
    }
    param.data =data ;
    
    console.log(data);

   
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






    param.dom = 'Bfrtip';
    param.lengthMenu = [
        [10, 25, 50, -1],
        ['10 éléments', '25 éléments', '50 éléments', 'tous éléments']
    ];
    param.buttons = ['pageLength', 'colvis',
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