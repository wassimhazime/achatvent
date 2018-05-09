     var affiche = document.getElementById("affiche");

        $(".form-string")
                .change(function () {
                  var content = "";
                  var charge = "";
                  $("select option:selected").each(function () {

                    content = $(this).data("infocontent");

                    var text = content.split("£££");
                    text.pop();

                    var info = "<div class='panel panel-primary'>  <div class='panel-heading'></div><div class='panel-body'   <p>";

                    for (var i = 0; i < text.length; i++) {
                      var data = text[i].split("$$$");

                      info += "<strong> " + data[0] + "     :</strong>   " + data[1] + "<br>";

                    }

                    charge = charge + info + "<hr> </div> <div class='panel-footer'>  </div> </div>";


                  });

                  $(affiche).html(charge);
                })
                .trigger("change");
