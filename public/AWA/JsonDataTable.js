"use strict";

/**
 * voir table par json 
 */
$.fn.dataTable.ext.buttons.alert = {

    action: function(e, dt, node, config) {
        alert(this.text());
    }
};



function DataTableJson(id, datajson, optiondatatable) {
    console.log(optiondatatable.split(" "));

    var table = $(id).DataTable({
        select: {
            style: 'multi'
        },

        dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 éléments', '25 éléments', '50 éléments', 'tous éléments']
        ]
        ,
        buttons: ['pageLength', 'colvis',
            optiondatatable.split(" "),

            {
                text: 'My button',
                className: 'btn btn-primary',
                extend: 'alert',
            },
            {
                text: 'Get selected data',
                action: function() {
                    var count = table.rows({selected: true}).count();

                    console.log(table.rows({selected: true}).data().toArray());
                    ;
                }
            }
        ]



        ,
        data: datajson["dataSet"],

        columns: datajson["titles"],

        lengthChange: false,

        language: {
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


    });
}