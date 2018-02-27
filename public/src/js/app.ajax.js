
        
$(document).ready(function () {
    var a=$('.ajax').text();  
 if(a.length<200){
    $.get(a,{},function (data) {
    $('.ajax').empty().html(data);
        
    }) ;}
    
   
    
    
})
        
        

