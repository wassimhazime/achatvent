"use strict";
$(document).ready(function() {
    /// class calcul
    var Calcule = function(HT, TVA, TTC) {
        this.HT = HT;
        this.TVA = TVA;
        this.TTC = TTC;
    }
    Calcule.prototype = {
        plus: function(a, b) {
            return ((a + b).toFixed(2));
        },
        moins: function(a, b) {
            return ((a - b).toFixed(2));
        },
        ht: function(HT) {
            var valueHT = ($(HT).val()) * 1;
            var valueTVA = (valueHT * 0.2);
            var valueTTC = this.plus(valueTVA, valueHT);
            this.TVA.val(valueTVA.toFixed(2));
            this.TTC.val(valueTTC);
        },
        tva: function(TVA) {
            var valueHT = ($ht.val()) * 1;
            var valueTVA = ($(TVA).val()) * 1;
            var valueTTC = this.plus(valueTVA, valueHT);
            this.TTC.val(valueTTC);
        },
        ttc: function(TTC) {
            var valueTTC = ($(TTC).val()) * 1;
            var valueHT = (valueTTC / 1.2);
            var valueTVA = this.moins(valueTTC, valueHT);
            this.TVA.val(valueTVA);
            this.HT.val(valueHT.toFixed(2));
        }

    }
    /////

    if (($("#id_html_montant_HT").val()) !== undefined) {
        var $ht = $("#id_html_montant_HT");
        var $tva = $("#id_html_montant_TVA");
        var $ttc = $("#id_html_montant_TTC");
        var calcul = new Calcule($ht, $tva, $ttc);
        $ht.keyup(function() {
            calcul.ht(this);
        }).keyup();
        $tva.keyup(function() {
            calcul.tva(this);
        }).keyup();
        $ttc.keyup(function() {
            calcul.ttc(this);
        }).keyup();


    } else if (($("#id_html_montant_avoirs_HT").val()) !== undefined) {
        var $ht = $("#id_html_montant_avoirs_HT");
        var $tva = $("#id_html_montant_avoirs_TVA");
        var $ttc = $("#id_html_montant_avoirs_TTC");
        var calcul = new Calcule($ht, $tva, $ttc);
        $ht.keyup(function() {
            calcul.ht(this);
        }).keyup();
        $tva.keyup(function() {
            calcul.tva(this);
        }).keyup();
        $ttc.keyup(function() {
            calcul.ttc(this);
        }).keyup();
    }


//// factures avoirs commandes devis ....


});