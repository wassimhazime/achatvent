//plugins multiSelect =>> setdata input auto 
// class plugins Multiselect 
var pluginsMultiSelectCalcule = function(config) {
    /// dat get multiselect
    this.preffixDATA = config.preffixDATA;

    // DOM
    /// bon facture 
    this.$montant_HT = $("#" + config.preffixDOM + "_montant_HT");
    this.$montant_TVA = $("#" + config.preffixDOM + "_montant_TVA");
    this.$montant_TTC = $("#" + config.preffixDOM + "_montant_TTC");

    // achat vente
    this.$factures_TTC = $("#" + config.preffixDOM + "_montant_factures_TTC");
    this.$avoirs_TTC = $("#" + config.preffixDOM + "_montant_avoirs_TTC");

}
pluginsMultiSelectCalcule.prototype = {
    parseDOM: function() {
        ///////////////////////////////////////////////
        // val
        this.val_montant_HT = parseFloat((this.$montant_HT.val()) * 1);
        this.val_montant_TVA = parseFloat((this.$montant_TVA.val()) * 1);
        this.val_montant_TTC = parseFloat((this.$montant_TTC.val()) * 1);


        this.val_factures_TTC = parseFloat((this.$factures_TTC.val()) * 1);
        this.val_avoirs_TTC = parseFloat((this.$avoirs_TTC.val()) * 1);

    },
    parseData: function() {
        var preffix = this.preffixDATA
        var data = this.data;
        ///////////////////////////////////////////////
        // data html

        this.ht = parseFloat(data[preffix + "montant_ht"]) * 1;     /// bone|| facture
        this.tva = parseFloat(data[preffix + "montant_tva"]) * 1;
        this.ttc = parseFloat(data[preffix + "montant_ttc"]) * 1;

        this.estime_ht = parseFloat(data[preffix + "montant_estime_ht"]) * 1; // commande


        this.ttc_avoirs = parseFloat(data[preffix + "montant_avoirs_ttc"]) * 1; /// payemment achat
    },
    calcule: function(op, data) {
        this.data = data;
        this.op = op;

        this.parseDOM();
        this.parseData();


        // traitement
        if (this.isNumber(this.val_montant_HT)) {
            if (this.isNumber(this.estime_ht)) {
                this.calculeCommande();
            } else if (this.isNumber(this.ht)) {
                this.calculeBoneFacture();
            }
        } else if (this.isNumber(this.val_factures_TTC)) {
            this.calculeReglement();
        }
    },
    calculeCommande: function() {
        this.$montant_HT.val(this.op(this.val_montant_HT, this.estime_ht));
        this.$montant_HT.addClass("input-lg ").keyup();
    },
    calculeBoneFacture: function() {
        this.$montant_HT.val(this.op(this.val_montant_HT, this.ht));
        this.$montant_TVA.val(this.op(this.val_montant_TVA, this.tva));
        this.$montant_TTC.val(this.op(this.val_montant_TTC, this.ttc));

    },
    calculeReglement: function() {
        if (this.isNumber(this.ttc)) {
            this.$factures_TTC.val(this.op(this.val_factures_TTC, this.ttc));
            this.$factures_TTC.keyup();
        } else if (this.isNumber(this.ttc_avoirs)) {
            this.$avoirs_TTC.val(this.op(this.val_avoirs_TTC, this.ttc_avoirs));
            this.$avoirs_TTC.keyup();
        }
    },
    isNumber: function(n) {
        return Number(n) === n;
    }


}
//*******************************************************//
//plugins multiSelect =>> graph
// class plugins Multiselect 
var pluginsMultiSelectGraph = function(config) {
    this.preffixDATA = config.preffixDATA;
    this.graph = config.graph;
    this.label = config.label;
    this.dataset = config.dataset;
}
pluginsMultiSelectGraph.prototype = {
    show: function(element) {
        //  console.log(element.find('option:selected'));
        var data = element.find('option:selected');
        var row = [];
        for (var i = 0; i < data.length; i++) {
            var ob = {};
            ob.label = $(data[i]).data(this.preffixDATA + this.label);
            ob.dataset = $(data[i]).data(this.preffixDATA + this.dataset);
            if (ob.label && ob.dataset) {
                row.push(ob);
            }
        }
        this.graph.set_Data(element.attr('id'), row);

    }

}

//*******************************************************//
// config multselect init
var AWA_ConfigMultiSelect = function(plugins) {
    this.afterInit = function() {
        var self = this;
        var $selectableSearch = self.$selectableUl.prev(); // input sherch <input  type='search'  class='search-input .....
        var $selectionSearch = self.$selectionUl.prev();
        var selectableSearchString = '#' + self.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)'; // select par id (id Math.random())
        var selectionSearchString = '#' + self.$container.attr('id') + ' .ms-elem-selection.ms-selected';
        this.qs1 = $selectableSearch.quicksearch(selectableSearchString).on('keydown', function(e) {
            if (e.which === 40) {
                self.$selectableUl.focus();
                return false;
            }
        });
        this.qs2 = $selectionSearch.quicksearch(selectionSearchString).on('keydown', function(e) {
            if (e.which == 40) {
                self.$selectionUl.focus();
                return false;
            }
        });
        this.Calcule = plugins.Calcule;
        this.Graph = plugins.Graph;
    };
    this.afterSelect = function(values, item) {
        this.qs1.cache();
        this.qs2.cache();
        this.Graph && this.Graph.show(this.$element);
        this.Calcule.calcule(function(a, b) {
            return ((a + b).toFixed(2));
        }, item.data());



    };
    this.afterDeselect = function(values, item) {
        this.qs1.cache();
        this.qs2.cache();
        this.Graph && this.Graph.show(this.$element);
        this.Calcule.calcule(function(a, b) {
            return ((a - b).toFixed(2));
        }, item.data());


    }


}
AWA_ConfigMultiSelect.prototype = {
    //selectableFooter: "<div class='searchable'>Selectable footer</div>",
    //selectionFooter: "<div class='searchable'>Selection footer</div>",
    "selectableHeader": "<input  type='search'  class='search-input img-thumbnail bg-info' autocomplete='off' placeholder='Rechercher'>",
    "selectionHeader": "<input type='search'   class='search-input img-thumbnail bg-info' autocomplete='off' placeholder='Rechercher'>",
    "dblClick": true,
    "cssClass": 'classjs_set_by_js_config'

}


//    $('#select-all').click(function() {
//        $('#public-methods').multiSelect('select_all');
//        return false;
//    });
//    $('#deselect-all').click(function() {
//        $('#public-methods').multiSelect('deselect_all');
//        return false;
//    });
//    $('#select-100').click(function() {
//        $('#public-methods').multiSelect('select', ['elem_3', 'elem_1', 'elem_2']);
//        return false;
//    });
//    $('#deselect-100').click(function() {
//        $('#public-methods').multiSelect('deselect', ['elem_3', 'elem_1', 'elem_2']);
//        return false;
//    });
//    $('#refresh').on('click', function() {
//        $('#public-methods').multiSelect('refresh');
//        return false;
//    });
//    $('#add-option').on('click', function() {
//        $('.searchable').multiSelect('addOption', {value: 42, text: 'test 42', index: 0});
//        return false;
//
//
//    });


//    $.each($(".ms-container"), function() {
//        var lisetItem = $(this).find("tbody>tr");
//        if (lisetItem[0] != undefined) {
//            if (lisetItem[0].innerText == "") {
//                $(this).hide();
//                $(this).parent().css("background-color", "#000");
//            }
// }
//    });
