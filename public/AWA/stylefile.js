"use strict";
/// class .inputfile
var inputs = document.querySelectorAll('.inputfile');
var id_math="id_math"+Math.ceil(Math.random() * 1000);
 var id_file = 'id_file' + id_math;
 $(inputs).attr("id",id_file);
$('  <label for="' + id_file + '"  ><span class="glyphicon glyphicon-paperclip btn btn-xs " style="font-size: 16px ;    background-color: #dcecfb;" ></span></label>').insertBefore(inputs);
$(inputs).css({
    "width": "0.1px",
    "height": "0.1px",
    "opacity": "0",
    "overflow": "hidden",
    "position": "absolute",
    " z-index": "-1"
})



Array.prototype.forEach.call(inputs, function(input)
{
    var label = input.previousElementSibling;
    input.addEventListener('change', function(e)
    {
        label.querySelector('span').innerHTML = this.files.length;
    }
    );
});