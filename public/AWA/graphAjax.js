"use strict";
function graphAjax($url) {
  $.getJSON($url, function (datajson) {

    var DJ = datajson[0];
    var lbj = [];
    var dataDJ = [];
    for (var k in DJ) {

      lbj.push(k);
      dataDJ.push(DJ[k]);

    }




    var ctx1 = document.getElementById('myChart1').getContext('2d');

    var chart1 = new Chart(ctx1, {
      // The type of chart we want to create
      type: 'bar',

      // The data for our dataset
      data: {
        labels: lbj,

        datasets: [{
            label: "raison socialer",
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
              'rgba(255,99,132,1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1,
            data: dataDJ,
          }
        ]
      },

      // Configuration options go here
      options: {
        scales: {
          yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
        }
      }
    });



  });

}