

<?php 
//index.php
$connect = mysqli_connect("localhost", "root", "", "brgy_mgmt");
$query = mysqli_query($connect, "SELECT YEAR(date_registered) AS year, (gender='Male') AS genMale, (gender='Female') AS genFemale, (gender='Non-Binary') AS genNonBinary FROM residence GROUP BY year");
// $query = "SELECT *, COUNT(residenceId) as countId,  YEAR(date_registered) AS year FROM residence GROUP BY YEAR(date_registered)";
$chart_data = '';
while($row = mysqli_fetch_array($query))
{
 $chart_data .= "{ Year:'".$row["year"]."', Male:".$row["genMale"].", Female:".$row["genFemale"]."}, ";
}
$chart_data = substr($chart_data, 0, -2);
?>


<!DOCTYPE html>
<html>
 <head>
  <title>Webslesson Tutorial | How to use Morris.js chart with PHP & Mysql</title>
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  
 </head>
 <body>
  <br /><br />
  <div class="container" style="width:900px;">
   <h2 align="center">Morris.js chart with PHP & Mysql</h2>
   <h3 align="center">Last 10 Years Profit, Purchase and Sale Data</h3>   
   <br /><br />
   <div id="chart"></div>
  </div>
 </body>
</html>

<script>
Morris.Line({
 element : 'chart',
 data:[<?php echo $chart_data; ?>],
 xkey:'Year',
 ykeys:['Male','Female'],
 labels:['Male','Female'],
 hideHover:'auto',
 stacked:true
});
</script>
