"use strict";
$(document).ready(function() {
    var content_child = $("#content-child");
    var inputs_child = $(".inputs-child");
    var add_button = $("#add_row");
    var idfile=1;
    $(add_button).click(function(e) {
        e.preventDefault();
      
       
        var new_row = inputs_child.clone();
        //style file
          idfile++;
        var id_file = 'idfile' + idfile;
       new_row.find("input[type='file']").attr("id", id_file);
        new_row.find("label").attr("for", id_file);
        new_row.find("label span").text("");
        new_row.find("input").val("");
        new_row.find("textarea").val("");
        
        $(content_child).append(new_row); //add input box


        var inputs = document.querySelectorAll('.inputfile');




        Array.prototype.forEach.call(inputs, function(input)
        {
            var label = input.previousElementSibling;
            input.addEventListener('change', function(e)
            {
                label.querySelector('span').innerHTML = this.files.length;
            }
            );
        });

    });

    $(content_child).on("click", ".delete", function(e) {
        e.preventDefault();
        $(this).parent('td').parent('tr').remove();

    });
});

