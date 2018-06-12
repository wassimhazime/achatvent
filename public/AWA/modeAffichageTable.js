$("#showMode").click(function(event) {
    event.preventDefault();
    if ($("#boxSelectMode").is(":visible")) {
        $("#boxSelectMode").fadeOut(200);
    } else {
        $("#boxSelectMode").slideDown(200);
    }




});

$("#hideMode").click(function(event) {
    event.preventDefault();
    $("#boxSelectMode").fadeOut(200);
    
});


