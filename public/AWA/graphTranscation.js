
var chart_Color_theme = {
    chartBackgroundColor: [
        'rgba(255, 255, 255, 1)',

        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',

        'rgba(255,99,132,0.5)',
        'rgba(54, 162, 235, 0.5)',
        'rgba(255, 206, 86, 0.5)',
        'rgba(75, 192, 192, 0.5)',
        'rgba(153, 102, 255, 0.5)',
        'rgba(255, 159, 64, 0.5)',

        'rgba(255,99,132,0.8)',
        'rgba(54, 162, 235, 0.8)',
        'rgba(255, 206, 86, 0.8)',
        'rgba(75, 192, 192, 0.8)',
        'rgba(153, 102, 255, 0.8)',
        'rgba(255, 159, 64, 0.8)',

        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
    ],

    chartBorderColor: [
        'rgba(255,255,255,1)',

        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
    ]

}



var graph_mini_info = new
        Chart(document.getElementById('graph_mini_info').getContext('2d'),
                {
                    // The type of chart we want to create
                    type: 'pie',

                    // The data for our dataset
                    data: {
                        labels: [" "],
                        datasets: [{
                                backgroundColor: chart_Color_theme.chartBackgroundColor,
                                borderColor: chart_Color_theme.chartBorderColor,
                                borderWidth: 1,
                                data: [0],
                            }]
                    },

                    // Configuration options go here
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Reglement TTC'
                        }
                    }
                });

var Reste_Reglement_global = 0;
var label_Reglement_global =  " Reste de Reglement TTC";

function Reste_Reglement(value) {
    Reste_Reglement_global = value;
    /// updat 
    graph_mini_info.data.labels[0] =label_Reglement_global;
    graph_mini_info.data.datasets[0].data[0] = value;
    graph_mini_info.update()
}


function data_change_graph(content_child, select_raw) {

    // remove
    var lableReste = label_Reglement_global;
    var valueReste = Reste_Reglement_global;

    graph_mini_info.data.labels = [lableReste];
    graph_mini_info.data.datasets[0].data = [valueReste];

    var $row = content_child.find(select_raw);

    $row.each(function() {
        var label = $(this).find("[type=date]").val();
        var value = $(this).find("[type=number]").val();
        // set dat graph

        graph_mini_info.data.labels.push(label);
        graph_mini_info.data.datasets.forEach(
                function(dataset) {
                    dataset.data.push(value);
                });
    })


    var datagraphsave = graph_mini_info.data.datasets[0].data;

    console.log(datagraphsave);
    for (var i = 1; i < datagraphsave.length; i++) {
        var d = datagraphsave[i] * 1;
        valueReste = valueReste - d;
    }
    console.log(valueReste);
    graph_mini_info.data.datasets[0].data[0] = valueReste;



    graph_mini_info.update();


}










