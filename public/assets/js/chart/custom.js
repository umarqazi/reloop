$(document).ready(function(){


  $(".owl-carousel").owlCarousel({

     items : 1,
     loop:false,
     rewind:true,
     margin : 30,
     nav    : true,
     smartSpeed :900,
     navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],

   });
  
});

// window.onload = function () {
//
// var chart = new CanvasJS.Chart("chartContainer-quart-1", {
// 	animationEnabled: true,
// 	theme: "light2",
// 	data: [{
// 		type: "column",
// 		dataPoints: [
// 			{ y: 15000, label: "Jan" },
// 			{ y: 18000,  label: "Feb" },
// 			{ y: 10000,  label: "Mar" },
// 			{ y: 9000,  label: "Apr" }
// 		]
// 	}]
// });
// chart.render();
// var chart = new CanvasJS.Chart("chartContainer-quart-2", {
// 	animationEnabled: true,
// 	theme: "light2",
// 	data: [{
// 		type: "column",
// 		dataPoints: [
// 			{ y: 15000, label: "May" },
// 			{ y: 18000,  label: "Jun" },
// 			{ y: 10000,  label: "Jul" },
// 			{ y: 9000,  label: "Aug" }
// 		]
// 	}]
// });
// chart.render();
// var chart = new CanvasJS.Chart("chartContainer-quart-3", {
// 	animationEnabled: true,
// 	theme: "light2",
// 	data: [{
// 		type: "column",
// 		dataPoints: [
// 			{ y: 15000, label: "Sep" },
// 			{ y: 18000,  label: "Oct" },
// 			{ y: 10000,  label: "Nov" },
// 			{ y: 9000,  label: "Dec" }
// 		]
// 	}]
// });
// chart.render();
// var chart = new CanvasJS.Chart("chartContainer-quart-4", {
// 	animationEnabled: true,
// 	theme: "light2",
// 	data: [{
// 		type: "column",
// 		dataPoints: [
// 			{ y: 15000, label: "Jan" },
// 			{ y: 18000,  label: "Feb" },
// 			{ y: 10000,  label: "Mar" },
// 			{ y: 9000,  label: "Apr" }
// 		]
// 	}]
// });
// chart.render();
// var chart = new CanvasJS.Chart("chartContainer-week1", {
// 	animationEnabled: true,
// 	theme: "light2",
// 	data: [{
// 		type: "column",
// 		legendText: "",
// 		dataPoints: [
// 			{ y: 15000, label: "2-mar" },
// 			{ y: 18000,  label: "3-mar" },
// 			{ y: 10000,  label: "4-mar" },
// 			{ y: 9000,  label: "5-mar" },
// 			{ y: 17000,  label: "6-mar" },
// 			{ y: 17500, label: "7-mar" },
// 			{ y: 11000,  label: "8-mar" }
// 		]
// 	}]
// });
// chart.render();
// var chart = new CanvasJS.Chart("chartContainer-week2", {
// 	animationEnabled: true,
// 	theme: "light2",
// 	data: [{
// 		type: "column",
// 		legendText: "",
// 		dataPoints: [
// 			{ y: 15000, label: "9-mar" },
// 			{ y: 18000,  label: "10-mar" },
// 			{ y: 10000,  label: "11-mar" },
// 			{ y: 9000,  label: "12-mar" },
// 			{ y: 17000,  label: "13-mar" },
// 			{ y: 17500, label: "14-mar" },
// 			{ y: 11000,  label: "15-mar" }
// 		]
// 	}]
// });
// chart.render();
// var chart = new CanvasJS.Chart("chartContainer-week3", {
// 	animationEnabled: true,
// 	theme: "light2",
// 	data: [{
// 		type: "column",
// 		legendText: "",
// 		dataPoints: [
// 			{ y: 15000, label: "16-mar" },
// 			{ y: 18000,  label: "17-mar" },
// 			{ y: 10000,  label: "18-mar" },
// 			{ y: 9000,  label: "19-mar" },
// 			{ y: 17000,  label: "20-mar" },
// 			{ y: 17500, label: "21-mar" },
// 			{ y: 11000,  label: "22-mar" }
// 		]
// 	}]
// });
// chart.render();
// var chart = new CanvasJS.Chart("chartContainer-week4", {
// 	animationEnabled: true,
// 	theme: "light2",
// 	data: [{
// 		type: "column",
// 		legendText: "",
// 		dataPoints: [
// 			{ y: 15000, label: "23-mar" },
// 			{ y: 18000,  label: "24-mar" },
// 			{ y: 10000,  label: "25-mar" },
// 			{ y: 9000,  label: "26-mar" },
// 			{ y: 17000,  label: "27-mar" },
// 			{ y: 17500, label: "28-mar" },
// 			{ y: 11000,  label: "29-mar" }
// 		]
// 	}]
// });
// chart.render();
// var chart = new CanvasJS.Chart("chartContainer-jan" , {
// 	animationEnabled: true,
// 	theme: "light2",
// 	data: [{
// 		type: "column",
// 		legendText: "",
// 		dataPoints: [
// 			{ y: 15000, label: "W1" },
// 			{ y: 18000,  label: "W2" },
// 			{ y: 10000,  label: "W3" },
// 			{ y: 9000,  label: "W4" }
// 		]
// 	}]
// });
// chart.render();
// var chart = new CanvasJS.Chart("chartContainer-feb" , {
// 	animationEnabled: true,
// 	theme: "light2",
// 	data: [{
// 		type: "column",
// 		legendText: "",
// 		dataPoints: [
// 			{ y: 15000, label: "W1" },
// 			{ y: 18000,  label: "W2" },
// 			{ y: 10000,  label: "W3" },
// 			{ y: 9000,  label: "W4" }
// 		]
// 	}]
// });
// chart.render();
// var chart = new CanvasJS.Chart("chartContainer-mar" , {
// 	animationEnabled: true,
// 	theme: "light2",
// 	data: [{
// 		type: "column",
// 		legendText: "",
// 		dataPoints: [
// 			{ y: 15000, label: "W1" },
// 			{ y: 18000,  label: "W2" },
// 			{ y: 10000,  label: "W3" },
// 			{ y: 9000,  label: "W4" }
// 		]
// 	}]
// });
// chart.render();
// var chart = new CanvasJS.Chart("chartContainer-apr" , {
// 	animationEnabled: true,
// 	theme: "light2",
// 	data: [{
// 		type: "column",
// 		legendText: "",
// 		dataPoints: [
// 			{ y: 15000, label: "W1" },
// 			{ y: 18000,  label: "W2" },
// 			{ y: 10000,  label: "W3" },
// 			{ y: 9000,  label: "W4" }
// 		]
// 	}]
// });
// chart.render();
// var chart = new CanvasJS.Chart("chartContainer-may" , {
// 	animationEnabled: true,
// 	theme: "light2",
// 	data: [{
// 		type: "column",
// 		legendText: "",
// 		dataPoints: [
// 			{ y: 15000, label: "W1" },
// 			{ y: 18000,  label: "W2" },
// 			{ y: 10000,  label: "W3" },
// 			{ y: 9000,  label: "W4" }
// 		]
// 	}]
// });
// chart.render();
// var chart = new CanvasJS.Chart("chartContainer-jun" , {
// 	animationEnabled: true,
// 	theme: "light2",
// 	data: [{
// 		type: "column",
// 		legendText: "",
// 		dataPoints: [
// 			{ y: 15000, label: "W1" },
// 			{ y: 18000,  label: "W2" },
// 			{ y: 10000,  label: "W3" },
// 			{ y: 9000,  label: "W4" }
// 		]
// 	}]
// });
// chart.render();
// var chart = new CanvasJS.Chart("chartContainer-jun" , {
// 	animationEnabled: true,
// 	theme: "light2",
// 	data: [{
// 		type: "column",
// 		legendText: "",
// 		dataPoints: [
// 			{ y: 15000, label: "W1" },
// 			{ y: 18000,  label: "W2" },
// 			{ y: 10000,  label: "W3" },
// 			{ y: 9000,  label: "W4" }
// 		]
// 	}]
// });
// chart.render();
// var chart = new CanvasJS.Chart("chartContainer-jul" , {
// 	animationEnabled: true,
// 	theme: "light2",
// 	data: [{
// 		type: "column",
// 		legendText: "",
// 		dataPoints: [
// 			{ y: 15000, label: "W1" },
// 			{ y: 18000,  label: "W2" },
// 			{ y: 10000,  label: "W3" },
// 			{ y: 9000,  label: "W4" }
// 		]
// 	}]
// });
// chart.render();
// var chart = new CanvasJS.Chart("chartContainer-aug" , {
// 	animationEnabled: true,
// 	theme: "light2",
// 	data: [{
// 		type: "column",
// 		legendText: "",
// 		dataPoints: [
// 			{ y: 15000, label: "W1" },
// 			{ y: 18000,  label: "W2" },
// 			{ y: 10000,  label: "W3" },
// 			{ y: 9000,  label: "W4" }
// 		]
// 	}]
// });
// chart.render();
// var chart = new CanvasJS.Chart("chartContainer-sep" , {
// 	animationEnabled: true,
// 	theme: "light2",
// 	data: [{
// 		type: "column",
// 		legendText: "",
// 		dataPoints: [
// 			{ y: 15000, label: "W1" },
// 			{ y: 18000,  label: "W2" },
// 			{ y: 10000,  label: "W3" },
// 			{ y: 9000,  label: "W4" }
// 		]
// 	}]
// });
// chart.render();
// var chart = new CanvasJS.Chart("chartContainer-jan" , {
// 	animationEnabled: true,
// 	theme: "light2",
// 	data: [{
// 		type: "column",
// 		legendText: "",
// 		dataPoints: [
// 			{ y: 15000, label: "W1" },
// 			{ y: 18000,  label: "W2" },
// 			{ y: 10000,  label: "W3" },
// 			{ y: 9000,  label: "W4" }
// 		]
// 	}]
// });
// chart.render();
// var chart = new CanvasJS.Chart("chartContainer-oct" , {
// 	animationEnabled: true,
// 	theme: "light2",
// 	data: [{
// 		type: "column",
// 		legendText: "",
// 		dataPoints: [
// 			{ y: 15000, label: "W1" },
// 			{ y: 18000,  label: "W2" },
// 			{ y: 10000,  label: "W3" },
// 			{ y: 9000,  label: "W4" }
// 		]
// 	}]
// });
// chart.render();
// var chart = new CanvasJS.Chart("chartContainer-nov" , {
// 	animationEnabled: true,
// 	theme: "light2",
// 	data: [{
// 		type: "column",
// 		legendText: "",
// 		dataPoints: [
// 			{ y: 15000, label: "W1" },
// 			{ y: 18000,  label: "W2" },
// 			{ y: 10000,  label: "W3" },
// 			{ y: 9000,  label: "W4" }
// 		]
// 	}]
// });
// chart.render();
// var chart = new CanvasJS.Chart("chartContainer-dec" , {
// 	animationEnabled: true,
// 	theme: "light2",
// 	data: [{
// 		type: "column",
// 		legendText: "",
// 		dataPoints: [
// 			{ y: 15000, label: "W1" },
// 			{ y: 18000,  label: "W2" },
// 			{ y: 10000,  label: "W3" },
// 			{ y: 9000,  label: "W4" }
// 		]
// 	}]
// });
// chart.render();

// var chart = new CanvasJS.Chart("chartContainer-pie", {
// 	animationEnabled: true,
// 	data: [{
// 		type: "pie",
// 		showInLegend: true,
// 		toolTipContent: "{name}: <strong>{y}%</strong>",
// 		indexLabel: "{name} - {y}%",
// 		 	dataPoints: [
// 			{ y: 26, name: "School Aid", exploded: true },
// 			{ y: 20, name: "Medical Aid" },
// 			{ y: 5, name: "Debt/Capital" },
// 			{ y: 3, name: "Elected Officials" },
// 			{ y: 7, name: "University" },
// 			{ y: 17, name: "Executive" },
// 		]
// 	}],
//   options: {
//     legend: {
//     	position: 'top',
//       alignment: 'right'
//     },
//     scales: {
//       yAxes: [{
//         ticks: {
//           beginAtZero: true,
//         }
//       }]
//     }
//   }
// });
// chart.render();
// }

// function explodePie (e) {
// 	if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
// 		e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
// 	} else {
// 		e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
// 	}
// 	e.chart.render();

// function toggleDataSeries(e) {
// 	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
// 		e.dataSeries.visible = false;
// 	} else {
// 		e.dataSeries.visible = true;
// 	}
// 	e.chart.render();
// }

//  }


// var ctx = document.getElementById("myChart").getContext('2d');
// var chart = new Chart(ctx, {
//   type: 'pie',
//   data: {
//     labels: ["Green", "Blue", "Gray", "Purple", "Yellow", "Red", "Black"],
//     datasets: [{
//       backgroundColor: [
//         "#2ecc71",
//         "#3498db",
//         "#95a5a6",
//         "#9b59b6",
//         "#f1c40f",
//         "#e74c3c",
//         "#34495e"
//       ],
//       data: [12, 19, 3, 17, 28, 24, 7]
//     }]
//   },
//   options: {
//     legend: {
//       display: false
//     },
//   }
// });
//
// // var myLegendContainer = document.getElementById("legend");
// // // generate HTML legend
// // myLegendContainer.innerHTML = chart.generateLegend();
// // // bind onClick event to all LI-tags of the legend
// // var legendItems = myLegendContainer.getElementsByTagName('li');
// // for (var i = 0; i < legendItems.length; i += 1) {
// //   legendItems[i].addEventListener("click", legendClickCallback, false);
// // }
// //
// // function legendClickCallback(event) {
// //   event = event || window.event;
// //
// //   var target = event.target || event.srcElement;
// //   while (target.nodeName !== 'LI') {
// //     target = target.parentElement;
// //   }
// //   var parent = target.parentElement;
// //   var chartId = parseInt(parent.classList[0].split("-")[0], 10);
// //   var chart = Chart.instances[chartId];
// //   var index = Array.prototype.slice.call(parent.children).indexOf(target);
// //   var meta = chart.getDatasetMeta(0);
// //   console.log(index);
// // 	var item = meta.data[index];
// //
// //   if (item.hidden === null || item.hidden === false) {
// //     item.hidden = true;
// //     target.classList.add('hidden');
// //   } else {
// //     target.classList.remove('hidden');
// //     item.hidden = null;
// //   }
// //   chart.update();
// // }



  
  
