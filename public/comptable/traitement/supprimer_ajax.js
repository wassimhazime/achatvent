
$(document).ready(function() {
$(" #example ").on("click",".supprimer",function(e) {
        alert("eeee")
    e.preventDefault();
    var elem=$(this);
      var url=(elem.data("urlsup"));
      elem.parents("tr[role='row']").hide(100);
        console.log(url);
        
         var ajax = new XMLHttpRequest();
       
        ajax.addEventListener("load", function() {
            
        }, false);
       
     //   ajax.open("GET",url);
        //ajax.send();
})

});
