"use strict";
$(document).ready(function() {
//*******************************************************//
//les class
//graphique style show
    var AWA_Chart = function(config) {
        var canva = document.getElementById(config.ElementById);
        if (!canva) {
            throw new Error('ereur select  id element canva ')
        }
        var type = config.type || 'pie';
        var title = config.title || ' ';
        var self = this;
        this.GRAPHIQUE = new Chart(canva,
                {
                    // The type of chart we want to create
                    type: type,
                    // The data for our dataset
                    data: {
                        labels: [" "],
                        datasets: [{
                                data: [0],

                                backgroundColor: self.chart_Color_theme.chartBackgroundColor,
                                borderColor: self.chart_Color_theme.chartBorderColor,
                                borderWidth: 1,
                            }]
                    },
                    // Configuration options go here
                    options: {
                        responsive: true,

                        title: {
                            display: true,
                            text: title
                        }
                    }
                });

        this.Reste_Reglement_global = 0;
        this.label_Reglement_global = " Reste de Reglement TTC";
    }
    AWA_Chart.prototype = {
        chart_Color_theme: {
            chartBackgroundColor: [
                'rgba(255, 255, 255, 1)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255,99,132,0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(255,99,132,0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 159, 64, 0.8)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
            ],
            chartBorderColor: [
                'rgba(255,255,255,1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
            ]

        },
        Reste_Reglement: function(value) {
            this.Reste_Reglement_global = value;

            this.GRAPHIQUE.data.labels[0] = this.label_Reglement_global;
            this.GRAPHIQUE.data.datasets.forEach((dataset) => {
                dataset.data[0] = value;
            });
            this.GRAPHIQUE.update();
        },
        data_change_graph: function(content_child, select_raw) {
            // remove
            var self = this;
            this.removeAllData();

            var valueReste = this.Reste_Reglement_global;
            this.Reste_Reglement(valueReste)
            var $row = content_child.find(select_raw);
            $row.each(function() {
                var label = $(this).find("[type=date]").val();
                var value = $(this).find("[type=number]").val();
                // set dat graph
                self.addData.call(self, label, value);

            })
            this.calcule_Reste_Reglement();

            this.GRAPHIQUE.update();
        },
        calcule_Reste_Reglement: function() {
            var valueReste = this.Reste_Reglement_global;
            var datagraphsave = this.GRAPHIQUE.data.datasets[0].data;
            console.log(datagraphsave);
            for (var i = 1; i < datagraphsave.length; i++) {
                var d = datagraphsave[i] * 1;
                valueReste = valueReste - d;
            }
            console.log(valueReste);
            this.GRAPHIQUE.data.datasets[0].data[0] = valueReste;
        },
        addData: function(label, data) {
            this.GRAPHIQUE.data.labels.push(label);
            //dataset pluseieur element avec un sel lable
            this.GRAPHIQUE.data.datasets.forEach((dataset) => {
                dataset.data.push(data);
            });
            this.GRAPHIQUE.update();
        },
        removeLastData: function() {
            this.GRAPHIQUE.data.labels.pop();
            //dataset pluseieur element avec un sel lable
            this.GRAPHIQUE.data.datasets.forEach((dataset) => {
                dataset.data.pop();
            });
            this.GRAPHIQUE.update();
        },
        removeAllData: function() {
            this.GRAPHIQUE.data.labels = [];
            this.GRAPHIQUE.data.datasets.forEach((dataset) => {
                dataset.data = [];
            });
            this.GRAPHIQUE.update();
        }

    }
//*******************************************************//
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

            this.montant_paye_ttc = parseFloat(data[preffix + "montant_paye_ttc"]) * 1;     /// payemment achat
            this.date_paye = data[preffix + "date"];     /// date payemment achat
            console.log(this.montant_paye_ttc, this.date_paye);





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
    var pluginsMultiSelectGraph = function() {

    }
    pluginsMultiSelectGraph.prototype = {

    }

//*******************************************************//
// config multselect init
    var ConfigMultiSelect = function(plugins) {
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
        };
        this.afterSelect = function(values, item) {
            this.qs1.cache();
            this.qs2.cache();
            this.Calcule.calcule(function(a, b) {
                return ((a + b).toFixed(2));
            }, item.data());

            console.log(item.data());
        };
        this.afterDeselect = function(values, item) {
            this.qs1.cache();
            this.qs2.cache();

            this.Calcule.calcule(function(a, b) {
                return ((a - b).toFixed(2));
            }, item.data());

            console.log(item.data());
        }


    }
    ConfigMultiSelect.prototype = {
        //selectableFooter: "<div class='searchable'>Selectable footer</div>",
        //selectionFooter: "<div class='searchable'>Selection footer</div>",
        "selectableHeader": "<input  type='search'  class='search-input img-thumbnail bg-info' autocomplete='off' placeholder='Rechercher'>",
        "selectionHeader": "<input type='search'   class='search-input img-thumbnail bg-info' autocomplete='off' placeholder='Rechercher'>",
        "dblClick": true,
        "cssClass": 'classjs_set_by_js_config'

    }

//*******************************************************//
// calcul tva avoir ttc HT ... input auto
    var CalculeAutoInput = function(config) {

        var preffix = config.preffix || "id_html";
        this.graph = config.graph || "";


        if (($("#" + preffix + "_Reglement_TTC").val()) !== undefined) {
            this.factures_TTC = $("#" + preffix + "_montant_factures_TTC");
            this.avoirs_TTC = $("#" + preffix + "_montant_avoirs_TTC");
            this.paye_TTC = $("#" + preffix + "_Reglement_TTC");

            this.event_calcule_reglement();
        } else {
            if (($("#" + preffix + "_montant_HT").val()) !== undefined) {
                this.HT = $("#" + preffix + "_montant_HT");
                this.TVA = $("#" + preffix + "_montant_TVA");
                this.TTC = $("#" + preffix + "_montant_TTC");
            } else if (($("#" + preffix + "_montant_avoirs_HT").val()) !== undefined) {
                this.HT = $("#" + preffix + "_montant_avoirs_HT");
                this.TVA = $("#" + preffix + "_montant_avoirs_TVA");
                this.TTC = $("#" + preffix + "l_montant_avoirs_TTC");

            }
            this.event_calcule_simple();
        }
    }
    CalculeAutoInput.prototype = {

        stylepaye_TTC: function(paye_TTC) {

            paye_TTC.prop('readonly', true);
            if (paye_TTC.val() < 0.00) {
                paye_TTC.css('background-color', 'red')
                        .css('color', '#000')
                        .addClass("input-lg ");
            } else if (paye_TTC.val() > 0.00) {
                paye_TTC.css('background-color', '#00ff80')
                        .css('color', '#000')
                        .addClass("input-lg ");
            } else {
                paye_TTC.css('background-color', '#ffffff')
                        .css('color', '000')
                        .removeClass("input-lg ");
            }

        },

        change: function(input, value) {
            this.graph.Reste_Reglement(value);
            console.log(input + "=>" + value);

        },

        calcule_paye_TTC: function(value_avoir_TTC, value_factures_TTC) {
            if (isNaN(value_avoir_TTC)) {
                this.paye_TTC.val(value_factures_TTC);
            } else {
                this.paye_TTC.val(this.moins(value_factures_TTC, value_avoir_TTC));
            }

            this.change("paye_TTC", this.paye_TTC.val());
            this.stylepaye_TTC(this.paye_TTC);
        },
        calcule_ht: function(HT) {

            var valueHT = ($(HT).val()) * 1;
            var valueTVA = (valueHT * 0.2);
            var valueTTC = this.plus(valueTVA, valueHT);
            this.TVA.val(valueTVA.toFixed(2));
            this.TTC.val(valueTTC);
        },
        calcule_tva: function(TVA) {
            var valueHT = (this.HT.val()) * 1;
            var valueTVA = ($(TVA).val()) * 1;
            var valueTTC = this.plus(valueTVA, valueHT);
            this.TTC.val(valueTTC);
        },
        calcule_ttc: function(TTC) {
            var valueTTC = ($(TTC).val()) * 1;
            var valueHT = (valueTTC / 1.2);
            var valueTVA = this.moins(valueTTC, valueHT);
            this.TVA.val(valueTVA);
            this.HT.val(valueHT.toFixed(2));
        },

        event_calcule_simple: function() {
            var self = this;
            this.HT.keyup(function() {
                self.calcule_ht(this);
            }).keyup();
            this.TVA.keyup(function() {
                self.calcule_tva(this);
            }).keyup();
            this.TTC.keyup(function() {
                self.calcule_ttc(this);
            }).keyup();
        },
        event_calcule_reglement: function() {
            var self = this;
            this.factures_TTC.keyup(function() {
                var value_factures_TTC = ($(this).val()) * 1;
                var value_avoir_TTC = (self.avoirs_TTC.val()) * 1;
                self.calcule_paye_TTC(value_avoir_TTC, value_factures_TTC);

            }).keyup();
            this.avoirs_TTC.keyup(function() {
                var value_factures_TTC = (self.factures_TTC.val()) * 1;
                var value_avoir_TTC = ($(this).val()) * 1;

                self.calcule_paye_TTC(value_avoir_TTC, value_factures_TTC);

            }).keyup();
        },
        plus: function(a, b) {
            return ((a + b).toFixed(2));
        },
        moins: function(a, b) {
            return ((a - b).toFixed(2));
        }

    }
//*******************************************************//
// tableform for chile  autoadd , style file icon  
    var FormChild = function(config) {
        var select_id = config.select_id || 'content-child';
        this.graph = config.graph || '';
        var self = this;
        // index row inputs
        this.id_index = 0;
        //id html table qui containrer input
        this.content_child = $("tbody[id=" + select_id + "]");
        //row html row qui containrer input
        this.inputs_child = this.content_child.find("tr");
        // inpule files
        this.$file = this.inputs_child.find("input[type='file']");
        this.id_file = this.$file.attr("id");
        this.name_file = this.$file.attr("name");
        // change name input file for php 
        this.$file.attr("name", this.name_file + this.id_index);
        this.add_button = $("#add_row");
        ///*************************///
        //events
        // delete row inputs 
        this.content_child.on("click", ".delete", function(e) {
            e.preventDefault();
            $(this).parent('td').parent('tr').remove();
            self.graph.data_change_graph(self.content_child, ".inputs-child");

        });
        // set data graph
        this.content_child.on("change", "input", function(e) {
            e.preventDefault();
            self.graph.data_change_graph(self.content_child, ".inputs-child");
        });
        // add row inputs 
        this.add_button.click(function(e) {
            e.preventDefault();
            self.id_index++;
            var new_row = self.inputs_child.clone();
            // vide data default(clone)
            new_row.find("label span").text("");
            new_row.find("input,textarea").val("");
            // agument id
            new_row.find("input,textarea,select").each(function() {
                var $input = $(this);
                var id = $input.attr("id");
                $input.attr("id", id + self.id_index);
            })
            // set event style file
            new_row.find("input[type='file']")
                    .each(function() {
                        var $fileRow = $(this);
                        var label = $fileRow.prev();
                        //id and name file id pour lable 
                        var id_local = self.id_file + self.id_index;
                        $fileRow.attr("id", id_local);
                        label.attr("for", id_local);
                        //and name pour php
                        $fileRow.attr("name", self.name_file + self.id_index);
                        // set theme pour lable
                        $fileRow.change(function(e)
                        {
                            label.find('span').html("");
                            var len = this.files.length;
                            if (len != 0) {
                                label.find('span').html(len);
                            }
                        }
                        );

                    })
            /// add row to table_form
            $(self.content_child).append(new_row); //add input box
        });

    }
    FormChild.prototype = {

    }

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++///

    var awa_Chart = new AWA_Chart({
        ElementById: 'graph_mini_info',
        type: 'pie',
        title: 'Reglement TTC',
    });

    new CalculeAutoInput({
        preffix: "id_html",
        graph: awa_Chart
    });

    new FormChild({
        select_id: "content-child",
        graph: awa_Chart
    });

    var configMultiSelect = new ConfigMultiSelect({
        Calcule: new pluginsMultiSelectCalcule({
            preffixDOM: "id_html",
            preffixDATA: "content_",
        }),
        graph: awa_Chart,
    });
    /// set config multi select
    $.each($('select[multiple]'), function() {
        $(this).multiSelect(configMultiSelect);
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