

$(document).ready(function () {

    $("a.whidden").click(function () {
        $("div#wjumbotron").toggle(222);
    });

 $('input[name="search"]').quicksearch('table#table_finde tbody tr', {
					loader: '.loading',
					noResults: '#noresults'
				});
 });
 
 	
