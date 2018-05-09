$(document).ready(function () {
  function plus(a, b) {
    return ((a + b).toFixed(2));
  }
  function moins(a, b) {
    return ((a - b).toFixed(2));
  }
//// factures avoirs commandes devis ....

  if (($("#id_html_montant_HT").val()) !== undefined) {
    var $ht = $("#id_html_montant_HT");
    var $tva = $("#id_html_montant_TVA");
    var $ttc = $("#id_html_montant_TTC");

  } else if (($("#id_html_montant_avoirs_HT").val()) !== undefined) {
    var $ht = $("#id_html_montant_avoirs_HT");
    var $tva = $("#id_html_montant_avoirs_TVA");
    var $ttc = $("#id_html_montant_avoirs_TTC");
  }

  $ht.keyup(function () {
    var valueHT = ($(this).val()) * 1;
    var valueTVA = (valueHT * 0.2);

    var valueTTC = plus(valueTVA, valueHT);
    $tva.val(valueTVA.toFixed(2));
    $ttc.val(valueTTC);


  }).keyup();
  $tva.keyup(function () {
    var valueHT = ($ht.val()) * 1;
    var valueTVA = ($(this).val()) * 1;

    var valueTTC = plus(valueTVA, valueHT);


    $ttc.val(valueTTC);
  }).keyup();
  $ttc.keyup(function () {
    var valueTTC = ($(this).val()) * 1;
    var valueHT = (valueTTC / 1.2);
    var valueTVA = moins(valueTTC, valueHT);
    $tva.val(valueTVA);
    $ht.val(valueHT.toFixed(2));
  }).keyup();








});