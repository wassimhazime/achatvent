$("#showMode").click(function(event) {
  event.preventDefault();
    $(this).fadeOut(200,function() {
       $("#boxSelectMode").fadeIn(200);  
    });
   
});
$("#hideMode").click(function(event) {
     event.preventDefault();
    $("#boxSelectMode").fadeOut(200,function() {
       $("#showMode").fadeIn(200);  
    });
   
});


