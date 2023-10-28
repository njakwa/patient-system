<!DOCTYPE html>
<html>
<head>
  <title>Temperature Chart</title>
  <!-- Include Chart.js library -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <div style="width: 80%; margin: 0 auto;">
    <canvas id="myAreaChart"></canvas>
  </div>

  <script>
    // Initialize an empty Chart.js chart
    var ctx = document.getElementById("myAreaChart");
    var myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: [],
        datasets: [{
          label: "Temperature",
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "rgba(78, 115, 223, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(78, 115, 223, 1)",
          pointBorderColor: "rgba(78, 115, 223, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
          pointHoverBorderColor: "rgba(78, 115, 223, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: [],
        }],
      },
      options: {
        maintainAspectRatio: false,
        layout: {
          padding: {
            left: 10,
            right: 25,
            top: 25,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            gridLines: {
              display: false,
              drawBorder: false
            },
          }],
          yAxes: [{
            ticks: {
              maxTicksLimit: 5,
              padding: 10,
            },
            gridLines: {
              color: "rgb(234, 236, 244)",
              zeroLineColor: "rgb(234, 236, 244)",
              drawBorder: false,
              borderDash: [2],
              zeroLineBorderDash: [2]
            }
          }],
        },
        legend: {
          display: false
        },
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          titleMarginBottom: 10,
          titleFontColor: '#6e707e',
          titleFontSize: 14,
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          intersect: false,
          mode: 'index',
          caretPadding: 10,
          callbacks: {
            label: function(tooltipItem, chart) {
              var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
              return datasetLabel + ': °C' + tooltipItem.yLabel + '°C'; // Modify units as needed
            }
          }
        }
      }
//     options: {
//     maintainAspectRatio: false,
//     layout: {
//       padding: {
//         left: 10,
//         right: 25,
//         top: 25,
//         bottom: 0
//       }
//     },
//     legend: {
//       display: false
//     },
//     tooltips: {
//       backgroundColor: "rgb(255,255,255)",
//       bodyFontColor: "#858796",
//       titleMarginBottom: 10,
//       titleFontColor: '#6e707e',
//       titleFontSize: 14,
//       borderColor: '#dddfeb',
//       borderWidth: 1,
//       xPadding: 15,
//       yPadding: 15,
//       displayColors: false,
//       intersect: false,
//       mode: 'index',
//       caretPadding: 10,
//       callbacks: {
//         label: function(tooltipItem, chart) {
//           var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
//           return datasetLabel + ': °C' + tooltipItem.yLabel + '°C'; // Modify units as needed
//         }
//       }
//     }
//   }


    });

    // Function to format timestamps as "HH:MM:SS" strings
    // function formatTimestamp(timestamp) {
    //   return timestamp.toTimeString().split(' ')[0];
    // }

    function formatTimestamp(timestamp) {
  // Assuming the timestamp is in 'Y-m-d H:i:s' format
  var dateParts = timestamp.split(' ');
  var timeParts = dateParts[1].split(':');
  return timeParts[0] + ':' + timeParts[1] + ':' + timeParts[2];
}
    // Function to update the chart with new data
    function updateChart() {
      // Use Ajax to fetch new data from your PHP endpoint
      $.ajax({
        url: 'fetch_new.php', // Replace with your PHP endpoint
        type: 'GET',
        dataType: 'json',
        success: function(data) {
          var temperatureData = data.temperatureData;
          var timestampData = data.timestampData;

          // Update chart labels with formatted timestamps
          var labels = timestampData.map(formatTimestamp);

          // Update the chart data
          myLineChart.data.labels = labels;
          myLineChart.data.datasets[0].data = temperatureData;

          // Update the chart
          myLineChart.update();
        },
        error: function(error) {
          console.error('Error fetching data:', error);
        }
      });
    }

    // Refresh the chart every 1 minute (adjust the interval as needed)
    setInterval(updateChart, 6000);
  </script>
</body>
</html>
