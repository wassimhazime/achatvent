"use strict";
$(document).ready(function() {
    var content_child = $("#content-child");
    var inputs_child = $(".inputs-child");

    var id_file = inputs_child.find("input[type='file']").attr("id");
    var name_file = inputs_child.find("input[type='file']").attr("name");


    var add_button = $("#add_row");
    var idfile = 0;

    inputs_child.find("input[type='file']")
            .attr("name", name_file + idfile);

    $(add_button).click(function(e) {
        e.preventDefault();


        var new_row = inputs_child.clone();

        //style file
        var $file = new_row.find("input[type='file']");
        idfile++;

        $file.attr("id", id_file + idfile)
                .attr("name", name_file + idfile);

        new_row.find("label").attr("for", id_file + idfile);
        new_row.find("label span").text("");
        new_row.find("input").val("");
        new_row.find("textarea").val("");

        $(content_child).append(new_row); //add input box


        var inputs = document.querySelectorAll('.inputfile');


        console.log(inputs);

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

