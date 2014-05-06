<?php  
include './Template.php';
include './DBConfig.php';
$mysql = new DBConfig();
$db = $mysql->getDBConfig();
include './data.php';
$head='    <style>
        #highcharts-0{
            overflow: initial !important;
            position: initial !important;
        }
    </style>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>';
$header = new Template("./header.php", array(head => $head, title => "Title"));
$header->out();
?>


<script type="text/javascript"> 
$(function () {
	  var chart;
	  $(document).ready(function() {
	    chart = new Highcharts.Chart({
	        chart: {
	            renderTo: 'container',
	            plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false
	        },
	        title: {
	            text: 'Task Completion Efficiency'
	        },
	        tooltip: {
	            pointFormat: '{series.name}: <b>{point.percentage}%</b>',
	            percentageDecimals: 1
	        },
	        plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                dataLabels: {
	                    enabled: true,
	                    color: '#000000',
	                    connectorColor: '#000000',
	                    formatter: function() {
	                        return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
	                    }
	                }
	            }
	        },
	        series: [{
	            type: 'pie',
	            name: 'Percentage',
	            data: [ <?php echo $myData;?> ]
	        }]
	    });
	});

	});
    </script>

    <style>
        
    </style>

<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
<?php 
include './footer.php';
?>