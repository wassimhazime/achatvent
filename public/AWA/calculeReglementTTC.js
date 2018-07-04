"use strict";
$(document).ready(function() {

    function plus(a, b) {
        return ((a + b).toFixed(2));
    }
    function moins(a, b) {
        return ((a - b).toFixed(2));
    }

    function stylepaye_TTC(paye_TTC) {
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

    }

    function change(input, value) {
        Reste_Reglement(value);
        console.log(input + "=>" + value);

    }


//////////////////////////////////////////////////////////////////////////////
/// achat 




    var factures_TTC = $("#id_html_montant_factures_TTC");
    var avoirs_TTC = $("#id_html_montant_avoirs_TTC");
    var paye_TTC = $("#id_html_Reglement_TTC");




    paye_TTC.prop('readonly', true);

    /// keyup change ( man ba3d)
    factures_TTC.keyup(function() {
        var value_factures_TTC = ($(this).val()) * 1;
        var value_avoir_TTC = (avoirs_TTC.val()) * 1;
        if (isNaN(value_avoir_TTC)) {
            paye_TTC.val(value_factures_TTC);
        } else {
            paye_TTC.val(moins(value_factures_TTC, value_avoir_TTC));
        }
        change("paye_TTC", paye_TTC.val());
        stylepaye_TTC(paye_TTC);
    }).keyup();
    avoirs_TTC.keyup(function() {
        var value_avoir_TTC = ($(this).val()) * 1;
        var value_factures_TTC = (factures_TTC.val()) * 1;
        paye_TTC.val(moins(value_factures_TTC, value_avoir_TTC));
        change("paye_TTC", paye_TTC.val());
        stylepaye_TTC(paye_TTC);
    }).keyup();





/////////////////////////////////////////////////////////////////////////////
// add row 
    var id_index = 0;
    //classe table qui containrer input
    var content_child = $("#content-child");
    //classe row qui containrer input
    var inputs_child = content_child.find(".inputs-child");
    // add row
    var add_button = $("#add_row");
    // delete row
    $(content_child).on("click", ".delete", function(e) {
        e.preventDefault();
        $(this).parent('td').parent('tr').remove();
        data_change_graph(content_child, ".inputs-child");

    });
    // set data graph
    $(content_child).on("change", "input", function(e) {
        e.preventDefault();
        data_change_graph(content_child, ".inputs-child");
    });



    ///*************************///

    var $file = inputs_child.find("input[type='file']");
    var id_file = $file.attr("id");
    var name_file = $file.attr("name");
    // change name input file for php 
    $file.attr("name", name_file + id_index);

    $(add_button).click(function(e) {
        e.preventDefault();
        id_index++;


        var new_row = inputs_child.clone();




        // vide data default(clone)
        new_row.find("label span").text("");
        new_row.find("input,textarea").val("");


        // agument id
        new_row.find("input,textarea,select").each(function() {
            var $input = $(this);
            var id = $input.attr("id");
            $input.attr("id", id + id_index);
        })

        // set event style file
        new_row.find("input[type='file']")
                .each(function() {
                    var $fileRow = $(this);
                    var label = $fileRow.prev();

                    //id and name file id pour lable 
                    var id_local = id_file + id_index;
                    $fileRow.attr("id", id_local);
                    label.attr("for", id_local);
                    //and name pour php
                    $fileRow.attr("name", name_file + id_index);

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
        $(content_child).append(new_row); //add input box
    });

});