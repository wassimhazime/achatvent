"use strict";
$(document).ready(function () {
  
  function plus(a, b) {
    return ((a + b).toFixed(2));
  }
  function moins(a, b) {
    return ((a - b).toFixed(2));
  }



//////////////////////////////////////////////////////////////////////////////
/// achat 




  var factures_TTC = $("#id_html_montant_factures_TTC");
  var avoirs_TTC = $("#id_html_montant_avoirs_TTC");

  var paye_TTC= $("#id_html_Reglement_TTC");

 


  paye_TTC.prop('readonly', true);

  factures_TTC.keyup(function () {
    var value_factures_TTC = ($(this).val()) * 1;
    var value_avoir_TTC = (avoirs_TTC.val()) * 1;
    if (isNaN(value_avoir_TTC)) {
      paye_TTC.val(value_factures_TTC);
    } else {
      paye_TTC.val(moins(value_factures_TTC, value_avoir_TTC));
    }

    stylepaye_TTC();
  }).keyup();


  avoirs_TTC.keyup(function () {
    var value_avoir_TTC = ($(this).val()) * 1;
    var value_factures_TTC = (factures_TTC.val()) * 1;
    paye_TTC.val(moins(value_factures_TTC, value_avoir_TTC));

    stylepaye_TTC();
  }).keyup();




  function stylepaye_TTC() {
    var value_reste_TTC = paye_TTC.val();
    if (value_reste_TTC < 0.00) {
      paye_TTC.css('background-color', 'red').css('color', '#000').addClass("input-lg ");
    } else if (value_reste_TTC > 0.00) {
      paye_TTC.css('background-color', '#00ff80').css('color', '#000').addClass("input-lg ");
    } else {

      paye_TTC.css('background-color', '#ffffff').css('color', '000').removeClass("input-lg ");

    }

  }



});