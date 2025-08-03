
<!DOCTYPE html>
<html lang='en' class=''>

<head>



  <style >


  </style>

  
<link rel="stylesheet" type="text/css" href="assets/css/3dchart.css"/>
</head>

<body>
  <script src="https://code.highcharts.com/highcharts.js?=<?=time();?>"></script>
<script src="https://code.highcharts.com/highcharts-3d.js?=<?=time();?>"></script>
<script src="https://code.highcharts.com/modules/exporting.js?=<?=time();?>"></script>
<script src="https://code.highcharts.com/modules/export-data.js?=<?=time();?>"></script>
<script src="https://code.highcharts.com/modules/accessibility.js?=<?=time();?>"></script>

<figure class="highcharts-figure">
  <div id="container"></div>
 
</figure>
  

<script type="text/javascript">
  Highcharts.chart('container', {
  chart: {
    type: 'pie',
    options3d: {
      enabled: true,
      alpha: 45,
      beta: 0
    }
  },
  title: {
    text: 'Browser market shares at a specific website, 2014'
  },
  accessibility: {
    point: {
      valueSuffix: '%'
    }
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      depth: 35,
      dataLabels: {
        enabled: true,
        format: '{point.name}'
      }
    }
  },
  series: [{
    type: 'pie',
    name: 'Browser share',
    data: [
      ['Firefox', 45.0],
      ['IE', 26.8],
      {
        name: 'Chrome',
        y: 12.8,
        sliced: true,
        selected: true
      },
      ['Safari', 8.5],
      ['Opera', 6.2],
      ['Others', 0.7]
    ]
  }]
});
</script>
</body>

</html>