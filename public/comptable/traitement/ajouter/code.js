(function() {
    function _(el) {
        return document.getElementById(el);
    }
    $("form").submit(function(e) {
        e.preventDefault();
        /*
         * code base class formHTML php
         * voir class formHTML
         */
        var formdata = chargeFormData();
        cacheFormHtml();
//send formdata par ajax
        ajaxSendData(formdata);
    });

    /**
     * charge form ajax 
     */
    function chargeFormData() {
        // new form ajax
        var formdata = new FormData();
        $("input:not([type='submit'],[type='reset'],[type='button'],[type='file']) ,textarea,select:not([multiple])").each(function(  ) {
            formdata.append(this.name, $(this).val());
        });
        $("select[multiple]").each(function() {
            var name = this.name;
            $($(this).val()).each(function() {
                formdata.append(name, this);
            })

        });
        $("input[type='file']").each(function() {
            var name = this.name;
            $(this.files).each(function() {
                formdata.append(name, this);
            })

        });
        return formdata;
    }

    /**
     * cache form and show progressbar
     */
    function cacheFormHtml() {
        _("progresshidden").classList.remove("hidden");
        _("formphp").classList.add("hidden");
    }

    /**
     * send data par ajax
     */


    function ajaxSendData(formdata) {
        var ajax = new XMLHttpRequest();

        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "#");

        ajax.send(formdata);
    }

/// call par ajaxSendData
    function precisionRound(number, precision) {
        var factor = Math.pow(10, precision);
        return Math.round(number * factor) / factor;
    }
    function progressHandler(event) {

        var percent = (event.loaded / event.total) * 100;
        _("progressBar").style.width = Math.round(percent) + "%";
        _("etat").innerHTML = "<h3>" + Math.round(percent) + "%</h3>";
        var load = precisionRound(event.loaded * 0.000001, 2);
        var total = precisionRound(event.total * 0.000001, 2);
        _("messageprogressBar").innerHTML = "Uploaded " + load + " MB of " + total;
    }
    function completeHandler(event) {
        _("status").innerHTML = event.target.responseText;

    }
    function errorHandler(event) {

        _("messageprogressBar").innerHTML = "Upload Failed";
    }
    function abortHandler(event) {
        _("messageprogressBar").innerHTML = "Upload Aborted";
    }
}
)()