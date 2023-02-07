<title>BMS | Dashboard</title>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<?php 
  
  include 'navbar.php'; 
  $query = mysqli_query($conn, "SELECT *, COUNT(residenceId) as countId,  YEAR(date_registered) AS year FROM residence GROUP BY YEAR(date_registered)");
  $chart_data = '';
  while($row = mysqli_fetch_array($query)) {
    $chart_data .= "{ Year:'".$row["year"]."', Population:".$row["countId"]."}, ";
  }
  $chart_data = substr($chart_data, 0, -2);

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid card">
        
        <div class="row d-flex justify-content-center ">
          
          <div class="col-md-5 mt-4 bg-light">
            <div class="card-header text-center mt-4 " style="min-height: 200px; max-height: 200px; max-width: 100%;">
                <?php
                  $users = mysqli_query($conn, "SELECT residenceId from residence");
                  $row_users = mysqli_num_rows($users);
                ?>
                <h1 class="mt-5" style="font-size: 70px"><?php echo $row_users; ?></h1>
                <!-- <p class="mb-5">Total Population</p> -->
            </div>
            <div class="card-footer bg-transparent">
              <h5 class="text-center">Total population</h5>
            </div>
          </div>

          <div class="col-md-5 mt-4">
            <div class="card-header bg-light">
              <div id="chart" style="min-height: 200px; max-height: 200px; max-width: 100%;"></div>
            </div>
            <div class="card-footer">
              <h5 class="text-center text-dark">Population by year</h5>
            </div>
          </div>

          <div style="width: 80%; margin-top: 30px;">
          <form action="getYearAnalytics.php" method="POST">
            <select name="getYear" id="getYear" class="form-control w-25" style="display: inline-block;">
              <?php if(isset($_GET['year'])){
              ?>
              <option value="<?php echo $_GET['year']; ?>" selected hidden><?php echo $_GET['year']; ?></option>
              <?php }
              
              for($i = date("Y"); $i >= 1990; $i--){
                echo "<option value='".$i."'>".$i."</option>";
              }
              ?>
            </select>
            <input type="submit" class="btn btn-info" value="Submit" style="display: inline-block;">
          </form>
          <div style="width: 100%;" id="populationLineChart"></div>

          </div>
      
          <div class="col-md-4 mt-4">
            <!-- <a href="detailedPopulation.php"> -->
              
              <div class="card-header">
                <canvas id="population" style="min-height: 200px; max-height: 200px; max-width: 100%;"></canvas>
              </div>
              <div class="card-footer">
                <h5 class="text-center text-dark">Population</h5>
              </div>
            <!-- </a> -->
          </div>
          
          <div class="col-md-4 mt-4">
              <div class="card-header">
                <canvas id="age" style="min-height: 200px; max-height: 200px; max-width: 100%;"></canvas>
              </div>
              <div class="card-footer">
                <h5 class="text-center">Age</h5>
              </div>
          </div>

          <div class="col-md-4 mt-4">
              <div class="card-header">
                <canvas id="sector" style="min-height: 200px; max-height: 200px; max-width: 100%;"></canvas>
              </div>
              <div class="card-footer">
                <h5 class="text-center">Sector</h5>
              </div>
          </div>

          <div class="col-md-4 mt-4">
              <div class="card-header">
                <canvas id="civilstatus" style="min-height: 200px; max-height: 200px; max-width: 100%;"></canvas>
              </div>
              <div class="card-footer">
                <h5 class="text-center">Civil Status</h5>
              </div>
          </div>

          <div class="col-md-4 mt-4">
              <div class="card-header">
                <canvas id="voters" style="min-height: 200px; max-height: 200px; max-width: 100%;"></canvas>
              </div>
              <div class="card-footer">
                <h5 class="text-center">Voters Status</h5>
              </div>
          </div>

          <div class="col-md-4 mt-4">
              <div class="card-header">
                <canvas id="IDstatus" style="min-height: 200px; max-height: 200px; max-width: 100%;"></canvas>
              </div>
              <div class="card-footer">
                <h5 class="text-center">ID Status</h5>
              </div>
          </div>


        </div>
          
        <div class="row">  
          <div class="col-md-12 mt-4 mb-2">
            <h3 class="m-0">Activity</h3>
          </div>
          <div class="col-md-12" id="activity">
            <div class="card card-info">
              <div class="card-header">
                <button type="button" class="btn btn-sm bg-white" data-toggle="modal" data-target="#add_activity"><i class="fa-sharp fa-solid fa-square-plus"></i> New Activity</button>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool pt-3" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                  <table id="examplse1" class="table table-bordered table-hover text-sm">
                    <thead>
                    <tr class="bg-light">
                      <th width="15%">DATE</th>
                      <th width="65%">TYPE OF ACTIVTY</th>
                      <th width="20%">ACTIONS</th>
                    </tr>
                    </thead>
                    <tbody id="users_data">
                      <?php 
                          $sql = mysqli_query($conn, "SELECT * FROM activity WHERE actDate >= '$date_today' ORDER BY actDate");
                          if(mysqli_num_rows($sql) > 0 ) {
                          while ($row = mysqli_fetch_array($sql)) {
                        ?>
                      <tr>
                          <?php if($row['actDate'] == $date_today): ?>
                            <td class="bg-white text-bold"><?php echo $row['actDate']; ?></td>
                            <td class="bg-white text-justify text-bold"><?php echo $row['actName']; ?></td>
                            <td class="bg-white">
                              <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#update<?php echo $row['actId']; ?>"><i class="fas fa-pencil-alt"></i> Edit</button>
                              <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete<?php echo $row['actId']; ?>"><i class="fas fa-trash"></i> Delete</button>
                            </td>
                          <?php else: ?>
                            <td class="bg-grey text-muted"><?php echo $row['actDate']; ?></td>
                            <td class="bg-grey text-muted text-justify"><?php echo $row['actName']; ?></td>
                            <td class="bg-grey text-muted">
                              <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#update<?php echo $row['actId']; ?>"><i class="fas fa-pencil-alt"></i> Edit</button>
                              <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete<?php echo $row['actId']; ?>"><i class="fas fa-trash"></i> Delete</button>
                            </td>
                          <?php endif; ?>
                            
                      </tr>
                      <?php include 'activity_update_delete.php'; } } else { ?>
                          <td colspan="100%" class="text-center">No activity found</td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>

<?php 
    include 'activity_add.php';
    include 'footer.php'; 

    // $getActityToday = mysqli_query($conn, "SELECT * FROM activity WHERE actDate='$date_today'");
    // if(mysqli_num_rows($getActityToday) > 0) {
    //   echo "<script>
    //         $(window).on('load', function() {
    //             $('#reminder').modal('show');
    //         });
    //     </script>"; 
    // }
?>


<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

 <script>




    Morris.Bar({
     element : 'chart',
     data:[<?php echo $chart_data; ?>],
     xkey:'Year',
     ykeys:['Population'],
     labels:['Population'],
     hideHover:'auto',
     stacked:true
    });
</script>

<script>
  $(function () {

   // POPULATION ****************************
    var donutChartCanvas = $('#population').get(0).getContext('2d')
    var donutData        = {

    labels: [ 'Male', 'Female', 'Non-Binary',],
     <?php 
      $sql = mysqli_query($conn, "SELECT count(residenceId) AS male FROM residence WHERE gender='Male' ");
      $row = mysqli_fetch_array($sql);

      $sql2 = mysqli_query($conn, "SELECT count(residenceId) AS female FROM residence WHERE gender='Female' ");
      $row2 = mysqli_fetch_array($sql2);

      $sql3 = mysqli_query($conn, "SELECT count(residenceId) AS nonbinary FROM residence WHERE gender='Non-Binary' ");
      $row3 = mysqli_fetch_array($sql3);

      echo " datasets: [ 
              { 
                data: [".$row['male'].", ".$row2['female'].", ".$row3['nonbinary']."], 
                backgroundColor : ['#f56954', '#00a65a', '#f39c12'],
              } 
             ] ";
      ?>
    }

    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      // type: 'pie',
      data: donutData,
      options: donutOptions
    })





    // AGE *****************************
    var donutChartCanvas = $('#age').get(0).getContext('2d')
    var donutData        = {

    labels: [ 'Toddler', 'Child', 'Teen', 'Young', 'Adult', 'Senior',],
     <?php 
            $sql = mysqli_query($conn, "SELECT count(residenceId) AS toddler FROM residence WHERE ageClassification='Toddler' ");
            $row = mysqli_fetch_array($sql);

            $sql2 = mysqli_query($conn, "SELECT count(residenceId) AS child FROM residence WHERE ageClassification='Child' ");
            $row2 = mysqli_fetch_array($sql2);

            $sql3 = mysqli_query($conn, "SELECT count(residenceId) AS teen FROM residence WHERE ageClassification='Teen' ");
            $row3 = mysqli_fetch_array($sql3);

            $sql4 = mysqli_query($conn, "SELECT count(residenceId) AS young FROM residence WHERE ageClassification='Young' ");
            $row4 = mysqli_fetch_array($sql4);

            $sql5 = mysqli_query($conn, "SELECT count(residenceId) AS adult FROM residence WHERE ageClassification='Adult' ");
            $row5 = mysqli_fetch_array($sql5);

            $sql6 = mysqli_query($conn, "SELECT count(residenceId) AS senior FROM residence WHERE ageClassification='Senior' ");
            $row6 = mysqli_fetch_array($sql6);

      echo " datasets: [ 
              { 
                data: [".$row['toddler'].", ".$row2['child'].", ".$row3['teen'].", ".$row4['young'].", ".$row5['adult'].", ".$row6['senior']."], 
                backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
              } 
             ] ";
      ?>
    }

    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      // type: 'pie',
      data: donutData,
      options: donutOptions
    })




    // SECTOR *****************************
    var donutChartCanvas = $('#sector').get(0).getContext('2d')
    var donutData        = {

    labels: [ 'Senior Citizen', 'Solo Parents', 'PWD',],
     <?php 
            $sql = mysqli_query($conn, "SELECT count(residenceId) AS senior FROM residence WHERE sector='Senior Citizen' ");
            $row = mysqli_fetch_array($sql);

            $sql2 = mysqli_query($conn, "SELECT count(residenceId) AS solo FROM residence WHERE sector='Solo Parents' ");
            $row2 = mysqli_fetch_array($sql2);

            $sql3 = mysqli_query($conn, "SELECT count(residenceId) AS pwd FROM residence WHERE sector='PWD' ");
            $row3 = mysqli_fetch_array($sql3);

      echo " datasets: [ 
              { 
                data: [".$row['senior'].", ".$row2['solo'].", ".$row3['pwd']."], 
                backgroundColor : ['#f56954', '#00a65a', '#f39c12'],
              } 
             ] ";
      ?>
    }

    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      // type: 'pie',
      data: donutData,
      options: donutOptions
    })





    // CIVIL STATUS *****************************
    var donutChartCanvas = $('#civilstatus').get(0).getContext('2d')
    var donutData        = {

    labels: [ 'Single', 'Married', 'Separated', 'Widow/ER',],
     <?php 
            $sql = mysqli_query($conn, "SELECT count(residenceId) AS single FROM residence WHERE civilstatus='Single' ");
            $row = mysqli_fetch_array($sql);

            $sql2 = mysqli_query($conn, "SELECT count(residenceId) AS married FROM residence WHERE civilstatus='Married' ");
            $row2 = mysqli_fetch_array($sql2);

            $sql3 = mysqli_query($conn, "SELECT count(residenceId) AS separated FROM residence WHERE civilstatus='Separated' ");
            $row3 = mysqli_fetch_array($sql3);

            $sql4 = mysqli_query($conn, "SELECT count(residenceId) AS widow FROM residence WHERE civilstatus='Widow/ER' ");
            $row4 = mysqli_fetch_array($sql4);

      echo " datasets: [ 
              { 
                data: [".$row['single'].", ".$row2['married'].", ".$row3['separated'].", ".$row4['widow']."], 
                backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
              } 
             ] ";
      ?>
    }

    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      // type: 'pie',
      data: donutData,
      options: donutOptions
    })




    // VOTERS *****************************
    var donutChartCanvas = $('#voters').get(0).getContext('2d')
    var donutData        = {

    labels: [ 'Active', 'Inactive', 'None',],
     <?php 
            $sql = mysqli_query($conn, "SELECT count(residenceId) AS Active FROM residence WHERE voter_status='Active' ");
            $row = mysqli_fetch_array($sql);

            $sql2 = mysqli_query($conn, "SELECT count(residenceId) AS Inactive FROM residence WHERE voter_status='Inactive' ");
            $row2 = mysqli_fetch_array($sql2);

            $sql3 = mysqli_query($conn, "SELECT count(residenceId) AS None FROM residence WHERE voter_status='None' ");
            $row3 = mysqli_fetch_array($sql3);

      echo " datasets: [ 
              { 
                data: [".$row['Active'].", ".$row2['Inactive'].", ".$row3['None']."], 
                backgroundColor : ['#f56954', '#00a65a', '#f39c12'],
              } 
             ] ";
      ?>
    }

    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      // type: 'pie',
      data: donutData,
      options: donutOptions
    })





    // AGE *****************************
    var donutChartCanvas = $('#IDstatus').get(0).getContext('2d')
    var donutData        = {

    labels: [ 'Active', 'Non',],
     <?php 
            $sql = mysqli_query($conn, "SELECT count(residenceId) AS active FROM residence WHERE ID_status='Active' ");
            $row = mysqli_fetch_array($sql);

            $sql2 = mysqli_query($conn, "SELECT count(residenceId) AS none FROM residence WHERE ID_status='None' ");
            $row2 = mysqli_fetch_array($sql2);


      echo " datasets: [ 
              { 
                data: [".$row['active'].", ".$row2['none']."], 
                backgroundColor : ['#f56954', '#00a65a'],
              } 
             ] ";
      ?>
    }

    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      // type: 'pie',
      data: donutData,
      options: donutOptions
    })

 
    



    <?php

        

    ?>



    var options = {
          series: [
          {
            name: "Population",
            <?php
            if(isset($_GET['year'])){
              $sqlQ1 = mysqli_query($conn, "SELECT COUNT(residenceId) as Jan FROM residence WHERE MONTH(`date_registered`) = 1 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows1 = mysqli_fetch_array($sqlQ1);
              $sqlQ2 = mysqli_query($conn, "SELECT COUNT(residenceId) as Feb FROM residence WHERE MONTH(`date_registered`) = 2 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows2 = mysqli_fetch_array($sqlQ2);
              $sqlQ3 = mysqli_query($conn, "SELECT COUNT(residenceId) as Mar FROM residence WHERE MONTH(`date_registered`) = 3 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows3 = mysqli_fetch_array($sqlQ3);
              $sqlQ4 = mysqli_query($conn, "SELECT COUNT(residenceId) as Apr FROM residence WHERE MONTH(`date_registered`) = 4 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows4 = mysqli_fetch_array($sqlQ4);
              $sqlQ5 = mysqli_query($conn, "SELECT COUNT(residenceId) as May FROM residence WHERE MONTH(`date_registered`) = 5 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows5 = mysqli_fetch_array($sqlQ5);
              $sqlQ6 = mysqli_query($conn, "SELECT COUNT(residenceId) as Jun FROM residence WHERE MONTH(`date_registered`) = 6 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows6 = mysqli_fetch_array($sqlQ6);
              $sqlQ7 = mysqli_query($conn, "SELECT COUNT(residenceId) as Jul FROM residence WHERE MONTH(`date_registered`) = 7 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows7 = mysqli_fetch_array($sqlQ7);
              $sqlQ8 = mysqli_query($conn, "SELECT COUNT(residenceId) as Aug FROM residence WHERE MONTH(`date_registered`) = 8 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows8 = mysqli_fetch_array($sqlQ8);
              $sqlQ9 = mysqli_query($conn, "SELECT COUNT(residenceId) as Sep FROM residence WHERE MONTH(`date_registered`) = 9 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows9 = mysqli_fetch_array($sqlQ9);
              $sqlQ10 = mysqli_query($conn, "SELECT COUNT(residenceId) as Oct FROM residence WHERE MONTH(`date_registered`) = 10 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows10 = mysqli_fetch_array($sqlQ10);
              $sqlQ11 = mysqli_query($conn, "SELECT COUNT(residenceId) as Nov FROM residence WHERE MONTH(`date_registered`) = 11 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows11 = mysqli_fetch_array($sqlQ11);
              $sqlQ12 = mysqli_query($conn, "SELECT COUNT(residenceId) as Dece FROM residence WHERE MONTH(`date_registered`) = 12 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows12 = mysqli_fetch_array($sqlQ12);
              echo "
                    data: [".$rows1['Jan'].", ".$rows2['Feb'].", ".$rows3['Mar'].", ".$rows4['Apr'].", ".$rows5['May'].", ".$rows6['Jun'].", ".$rows7['Jul'].", ".$rows8['Aug'].", ".$rows9['Sep'].", ".$rows10['Oct'].", ".$rows11['Nov'].", ".$rows12['Dece']."]
                     ";
            }
                

              ?>
          },
          {
            name: "Male",
            <?php
            if(isset($_GET['year'])){
              $sqlQ1 = mysqli_query($conn, "SELECT COUNT(residenceId) as Jan FROM residence WHERE gender='Male' AND MONTH(`date_registered`) = 1 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows1 = mysqli_fetch_array($sqlQ1);
              $sqlQ2 = mysqli_query($conn, "SELECT COUNT(residenceId) as Feb FROM residence WHERE gender='Male' AND MONTH(`date_registered`) = 2 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows2 = mysqli_fetch_array($sqlQ2);
              $sqlQ3 = mysqli_query($conn, "SELECT COUNT(residenceId) as Mar FROM residence WHERE gender='Male' AND MONTH(`date_registered`) = 3 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows3 = mysqli_fetch_array($sqlQ3);
              $sqlQ4 = mysqli_query($conn, "SELECT COUNT(residenceId) as Apr FROM residence WHERE gender='Male' AND MONTH(`date_registered`) = 4 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows4 = mysqli_fetch_array($sqlQ4);
              $sqlQ5 = mysqli_query($conn, "SELECT COUNT(residenceId) as May FROM residence WHERE gender='Male' AND MONTH(`date_registered`) = 5 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows5 = mysqli_fetch_array($sqlQ5);
              $sqlQ6 = mysqli_query($conn, "SELECT COUNT(residenceId) as Jun FROM residence WHERE gender='Male' AND MONTH(`date_registered`) = 6 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows6 = mysqli_fetch_array($sqlQ6);
              $sqlQ7 = mysqli_query($conn, "SELECT COUNT(residenceId) as Jul FROM residence WHERE gender='Male' AND MONTH(`date_registered`) = 7 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows7 = mysqli_fetch_array($sqlQ7);
              $sqlQ8 = mysqli_query($conn, "SELECT COUNT(residenceId) as Aug FROM residence WHERE gender='Male' AND MONTH(`date_registered`) = 8 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows8 = mysqli_fetch_array($sqlQ8);
              $sqlQ9 = mysqli_query($conn, "SELECT COUNT(residenceId) as Sep FROM residence WHERE gender='Male' AND MONTH(`date_registered`) = 9 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows9 = mysqli_fetch_array($sqlQ9);
              $sqlQ10 = mysqli_query($conn, "SELECT COUNT(residenceId) as Oct FROM residence WHERE gender='Male' AND MONTH(`date_registered`) = 10 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows10 = mysqli_fetch_array($sqlQ10);
              $sqlQ11 = mysqli_query($conn, "SELECT COUNT(residenceId) as Nov FROM residence WHERE gender='Male' AND MONTH(`date_registered`) = 11 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows11 = mysqli_fetch_array($sqlQ11);
              $sqlQ12 = mysqli_query($conn, "SELECT COUNT(residenceId) as Dece FROM residence WHERE gender='Male' AND MONTH(`date_registered`) = 12 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows12 = mysqli_fetch_array($sqlQ12);
              echo "
                    data: [".$rows1['Jan'].", ".$rows2['Feb'].", ".$rows3['Mar'].", ".$rows4['Apr'].", ".$rows5['May'].", ".$rows6['Jun'].", ".$rows7['Jul'].", ".$rows8['Aug'].", ".$rows9['Sep'].", ".$rows10['Oct'].", ".$rows11['Nov'].", ".$rows12['Dece']."]
                     ";
            }
                

              ?>
          },
          {
            name: "Female",
            <?php
            if(isset($_GET['year'])){
              $sqlQ1 = mysqli_query($conn, "SELECT COUNT(residenceId) as Jan FROM residence WHERE gender='Female' AND MONTH(`date_registered`) = 1 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows1 = mysqli_fetch_array($sqlQ1);
              $sqlQ2 = mysqli_query($conn, "SELECT COUNT(residenceId) as Feb FROM residence WHERE gender='Female' AND MONTH(`date_registered`) = 2 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows2 = mysqli_fetch_array($sqlQ2);
              $sqlQ3 = mysqli_query($conn, "SELECT COUNT(residenceId) as Mar FROM residence WHERE gender='Female' AND MONTH(`date_registered`) = 3 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows3 = mysqli_fetch_array($sqlQ3);
              $sqlQ4 = mysqli_query($conn, "SELECT COUNT(residenceId) as Apr FROM residence WHERE gender='Female' AND MONTH(`date_registered`) = 4 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows4 = mysqli_fetch_array($sqlQ4);
              $sqlQ5 = mysqli_query($conn, "SELECT COUNT(residenceId) as May FROM residence WHERE gender='Female' AND MONTH(`date_registered`) = 5 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows5 = mysqli_fetch_array($sqlQ5);
              $sqlQ6 = mysqli_query($conn, "SELECT COUNT(residenceId) as Jun FROM residence WHERE gender='Female' AND MONTH(`date_registered`) = 6 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows6 = mysqli_fetch_array($sqlQ6);
              $sqlQ7 = mysqli_query($conn, "SELECT COUNT(residenceId) as Jul FROM residence WHERE gender='Female' AND MONTH(`date_registered`) = 7 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows7 = mysqli_fetch_array($sqlQ7);
              $sqlQ8 = mysqli_query($conn, "SELECT COUNT(residenceId) as Aug FROM residence WHERE gender='Female' AND MONTH(`date_registered`) = 8 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows8 = mysqli_fetch_array($sqlQ8);
              $sqlQ9 = mysqli_query($conn, "SELECT COUNT(residenceId) as Sep FROM residence WHERE gender='Female' AND MONTH(`date_registered`) = 9 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows9 = mysqli_fetch_array($sqlQ9);
              $sqlQ10 = mysqli_query($conn, "SELECT COUNT(residenceId) as Oct FROM residence WHERE gender='Female' AND MONTH(`date_registered`) = 10 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows10 = mysqli_fetch_array($sqlQ10);
              $sqlQ11 = mysqli_query($conn, "SELECT COUNT(residenceId) as Nov FROM residence WHERE gender='Female' AND MONTH(`date_registered`) = 11 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows11 = mysqli_fetch_array($sqlQ11);
              $sqlQ12 = mysqli_query($conn, "SELECT COUNT(residenceId) as Dece FROM residence WHERE gender='Female' AND MONTH(`date_registered`) = 12 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows12 = mysqli_fetch_array($sqlQ12);
              echo "
                    data: [".$rows1['Jan'].", ".$rows2['Feb'].", ".$rows3['Mar'].", ".$rows4['Apr'].", ".$rows5['May'].", ".$rows6['Jun'].", ".$rows7['Jul'].", ".$rows8['Aug'].", ".$rows9['Sep'].", ".$rows10['Oct'].", ".$rows11['Nov'].", ".$rows12['Dece']."]
                     ";
            }
                

              ?>
          },{
            name: "Non-Binary",
            <?php
            if(isset($_GET['year'])){
              $sqlQ1 = mysqli_query($conn, "SELECT COUNT(residenceId) as Jan FROM residence WHERE gender='Non-Binary' AND MONTH(`date_registered`) = 1 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows1 = mysqli_fetch_array($sqlQ1);
              $sqlQ2 = mysqli_query($conn, "SELECT COUNT(residenceId) as Feb FROM residence WHERE gender='Non-Binary' AND MONTH(`date_registered`) = 2 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows2 = mysqli_fetch_array($sqlQ2);
              $sqlQ3 = mysqli_query($conn, "SELECT COUNT(residenceId) as Mar FROM residence WHERE gender='Non-Binary' AND MONTH(`date_registered`) = 3 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows3 = mysqli_fetch_array($sqlQ3);
              $sqlQ4 = mysqli_query($conn, "SELECT COUNT(residenceId) as Apr FROM residence WHERE gender='Non-Binary' AND MONTH(`date_registered`) = 4 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows4 = mysqli_fetch_array($sqlQ4);
              $sqlQ5 = mysqli_query($conn, "SELECT COUNT(residenceId) as May FROM residence WHERE gender='Non-Binary' AND MONTH(`date_registered`) = 5 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows5 = mysqli_fetch_array($sqlQ5);
              $sqlQ6 = mysqli_query($conn, "SELECT COUNT(residenceId) as Jun FROM residence WHERE gender='Non-Binary' AND MONTH(`date_registered`) = 6 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows6 = mysqli_fetch_array($sqlQ6);
              $sqlQ7 = mysqli_query($conn, "SELECT COUNT(residenceId) as Jul FROM residence WHERE gender='Non-Binary' AND MONTH(`date_registered`) = 7 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows7 = mysqli_fetch_array($sqlQ7);
              $sqlQ8 = mysqli_query($conn, "SELECT COUNT(residenceId) as Aug FROM residence WHERE gender='Non-Binary' AND MONTH(`date_registered`) = 8 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows8 = mysqli_fetch_array($sqlQ8);
              $sqlQ9 = mysqli_query($conn, "SELECT COUNT(residenceId) as Sep FROM residence WHERE gender='Non-Binary' AND MONTH(`date_registered`) = 9 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows9 = mysqli_fetch_array($sqlQ9);
              $sqlQ10 = mysqli_query($conn, "SELECT COUNT(residenceId) as Oct FROM residence WHERE gender='Non-Binary' AND MONTH(`date_registered`) = 10 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows10 = mysqli_fetch_array($sqlQ10);
              $sqlQ11 = mysqli_query($conn, "SELECT COUNT(residenceId) as Nov FROM residence WHERE gender='Non-Binary' AND MONTH(`date_registered`) = 11 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows11 = mysqli_fetch_array($sqlQ11);
              $sqlQ12 = mysqli_query($conn, "SELECT COUNT(residenceId) as Dece FROM residence WHERE gender='Non-Binary' AND MONTH(`date_registered`) = 12 AND YEAR(`date_registered`) =".$_GET['year']);
              $rows12 = mysqli_fetch_array($sqlQ12);
              echo "
                    data: [".$rows1['Jan'].", ".$rows2['Feb'].", ".$rows3['Mar'].", ".$rows4['Apr'].", ".$rows5['May'].", ".$rows6['Jun'].", ".$rows7['Jul'].", ".$rows8['Aug'].", ".$rows9['Sep'].", ".$rows10['Oct'].", ".$rows11['Nov'].", ".$rows12['Dece']."]
                     ";
            }
                

              ?>

          }
        ],
          chart: {
          height: 350,
          type: 'line',
          dropShadow: {
            enabled: true,
            color: '#000',
            top: 18,
            left: 7,
            blur: 10,
            opacity: 0.2
          },
          toolbar: {
            show: false
          }
        },
        colors: ['#000', '#f36953', '#00a65a','#fec308'],
        dataLabels: {
          enabled: true,
        },
        stroke: {
          curve: 'smooth'
        },
        title: {
          text: 'Records',
          align: 'left'
        },
        grid: {
          borderColor: '#e7e7e7',
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        markers: {
          size: 1
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul','Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          title: {
            text: 'Month'
          }
        },
        yaxis: {
          title: {
            text: 'Records'
          }
        },
        legend: {
          position: 'top',
          horizontalAlign: 'right',
          floating: true,
          offsetY: -25,
          offsetX: -5
        }
        };

        var chart = new ApexCharts(document.querySelector("#populationLineChart"), options);
        chart.render();











  })
</script>

