
$(document).ready(function() {

    $.each($('select[multiple]'), function() {
        (function($this) {
            $($this).multiSelect(
                    {
                        "afterInit": function(ms) {
                            var that = this;
                            var $selectableSearch = that.$selectableUl.prev(); // input sherch <input  type='search'  class='search-input .....
                            var $selectionSearch = that.$selectionUl.prev();
                            var selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)'; // select par id (id Math.random())
                            var selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';
                            that.qs1 = $selectableSearch.quicksearch(selectableSearchString).on('keydown', function(e) {
                                if (e.which === 40) {
                                    that.$selectableUl.focus();
                                    return false;
                                }
                            });
                            that.qs2 = $selectionSearch.quicksearch(selectionSearchString).on('keydown', function(e) {
                                if (e.which == 40) {
                                    that.$selectionUl.focus();
                                    return false;
                                }
                            });
                           
                            that.calcule = function(data, op) {


                                //////////////////////////////////////////////////////////////////
                                // DOM
                                /// bon facture
                                var $montant_HT = $("#id_html_montant_HT");
                                var $montant_TVA = $("#id_html_montant_TVA");
                                var $montant_TTC = $("#id_html_montant_TTC");

                                // achat vente
                                var $factures_TTC = $("#id_html_montant_factures_TTC");
                                var $avoirs_TTC = $("#id_html_montant_avoirs_TTC");

                                ///////////////////////////////////////////////
                                // val


                                var val_montant_HT = parseFloat(($montant_HT.val()) * 1);
                                var val_montant_TVA = parseFloat(($montant_TVA.val()) * 1);
                                var val_montant_TTC = parseFloat(($montant_TTC.val()) * 1);


                                var val_factures_TTC = parseFloat(($factures_TTC.val()) * 1);
                                var val_avoirs_TTC = parseFloat(($avoirs_TTC.val()) * 1);


                                ///////////////////////////////////////////////
                                // data html
                                
                                var ht = parseFloat(data.content_montant_ht) * 1;     /// bone|| facture
                                var tva = parseFloat(data.content_montant_tva) * 1;
                                var ttc = parseFloat(data.content_montant_ttc) * 1;
                                 
                                var estime_ht = parseFloat(data.content_montant_estime_ht) * 1; // commande
                        
                                var ht_avoirs = parseFloat(data.content_montant_avoirs_ht) * 1;     /// avoirs
                                var tva_avoirs = parseFloat(data.content_montant_avoirs_tva) * 1;
                                var ttc_avoirs = parseFloat(data.content_montant_avoirs_ttc) * 1;




                                /////////////////////////////////
                                // traitement
                               
                                if (this.isNumber(val_montant_HT)) {
                                 
                                    if (this.isNumber(estime_ht)) {
                                        $montant_HT.val(op(val_montant_HT, estime_ht));
                                        $montant_HT.addClass("input-lg ").keyup();

                                    } else if (this.isNumber(ht)) {
                                        $montant_HT.val(op(val_montant_HT, ht));
                                        $montant_TVA.val(op(val_montant_TVA, tva));
                                        $montant_TTC.val(op(val_montant_TTC, ttc));
                                    }
                                } else if (this.isNumber(val_factures_TTC)) {
                                    if (this.isNumber(ttc)) {
                                        $factures_TTC.val(op(val_factures_TTC, ttc));
                                        $factures_TTC.keyup();
                                    } else if (this.isNumber(ttc_avoirs)) {
                                        $avoirs_TTC.val(op(val_avoirs_TTC, ttc_avoirs));
                                        $avoirs_TTC.keyup();
                                    }
                                }

                            };
                            that.isNumber = function(n) {
                                return Number(n) === n;
                            };

                        },
                        "afterSelect": function(values, item) {
                            this.qs1.cache();
                            this.qs2.cache();
                            var data = item.data();
                            this.calcule(data, function(a, b) {
                                return ((a + b).toFixed(2));
                            });
                            console.log(item.data());
                        },
                        "afterDeselect": function(values, item) {
                            this.qs1.cache();
                            this.qs2.cache();
                            var data = item.data();
                            this.calcule(data, function(a, b) {
                                return ((a - b).toFixed(2));
                            });
                            console.log(item.data());
                        },
                        //selectableFooter: "<div class='searchable'>Selectable footer</div>",
                        //selectionFooter: "<div class='searchable'>Selection footer</div>",
                        "selectableHeader": "<input  type='search'  class='search-input img-thumbnail bg-info' autocomplete='off' placeholder='Rechercher'>",
                        "selectionHeader": "<input type='search'   class='search-input img-thumbnail bg-info' autocomplete='off' placeholder='Rechercher'>",
                        "dblClick": true,
                        "cssClass": 'wassim_class'
                    }
            );

        })(this);
    });




















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
});