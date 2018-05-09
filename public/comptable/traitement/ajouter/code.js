function _(el) {
  return document.getElementById(el);
}


$("#setdataparAjax").click(function () {
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

  // select input  form html type string =>>> darori class form-control-file
  var formdatahtml = document.getElementsByClassName("form-string");
  // add data string to from ajax (name value)
  for (var i = 0; i < formdatahtml.length; i++) {

    formdata.append(formdatahtml[i].name, formdatahtml[i].value);
  }
  // select input  form html type string childs =>>> darori class form-childs
  var formdatahtmlchilds = document.getElementsByClassName("form-childs");
  // add data string to from ajax (childs value,value,value,value)
  for (var i = 0; i < formdatahtmlchilds.length; i++) {


    var formdatahtmlchild = (formdatahtmlchilds[i]);
    var name = formdatahtmlchild.name;

    for (var h = 0; h < formdatahtmlchild.length; h++) {
     
      var currentOption = formdatahtmlchild[h];
  
      if (currentOption.selected == true) {
        formdata.append(name, currentOption.value);

      }

    }

  }
  
  // select input from html type file =>>> darori class form-control-file
  var formdatafileshtml = document.getElementsByClassName("form-file");
  // add data file to from ajax (name[] value1,value2,....)
  for (var i = 0; i < formdatafileshtml.length; i++) {
    var files = formdatafileshtml[i].files;
    var name = (formdatafileshtml[i].name);
    for (var l = 0; l < files.length; l++) {
      // add data file to from ajax (name[] value1,value2,....) 
      formdata.append(name, files[l]);

    }
  }

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