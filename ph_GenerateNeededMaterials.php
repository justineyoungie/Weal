<?php
    session_start();
    require_once("mysql_connect.php");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>List of Needed Materials</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel ="stylesheet" type = "text/css" href ="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <link rel ="stylesheet" type = "text/css" href ="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" />
  
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/customs.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>WBI</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><font face="Open Sans"><b>Weal Builders Inc.</b> </font></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs">Alexander Pierce</span>
            </a>
            <ul class="dropdown-menu pull-right">
              <!-- User image -->
              <li class="user-header">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  Alexander Pierce - Web Developer
                  <small>Member since Nov. 2012</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu pull-right">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
		  
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <font color="white" size="3.5" face="Open Sans">Alexander Pierce </font><br>
          <font face="Open Sans" size="1" color="white">Purchasing</font>
        </div>
        <div class="pull-left info">
          
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
		
        <li class="header">MAIN NAVIGATION</li>
        <li>
            <a href="ph_GenerateNeededMaterials.php">Generate Needed Materials</a>
        </li>
        <li>
          <a href="ph_InputPrices.php">Input Prices from Suppliers</a>
        </li>
      </ul>
		
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	
	<div id="page-wrapper">
        <div class="container-fluid">
            <div class="col-xs-12 box">
                
                <!-- INSERT CONTENT HERE -->
                <section class="content-header">
                  <h1>
                    List of Needed Materials<br>
                    <small>Lists all materials requested</small>
                  </h1>
                  <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                  </ol>
                </section>
              <br>
              <!-- Main content -->
              <section class="content">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                  <div class="col-xs-12">
                      <div class="box-header">
                        <h3 class="box-title">Materials</h3>
                        <br>
                        <?php
                            date_default_timezone_set("Asia/Manila");
                            echo "<small>";
                            echo "Generated: " . date("M d, Y") . " " . date("h:i:sa");
                            echo "</small>";
                        ?>
                      </div>
                    <!-- /.box-header -->
                      <div class="box-body">
                        <?php 
                          //change depending on how justine wants it
                          $supQuery = "
                                        SELECT * 
                                        FROM suppliers
                                        ";
                            $supResult=mysqli_query($dbc,$supQuery);
                            if (!$supResult) {
                                printf("Error: %s\n", mysqli_error($dbc));
                                exit();
                            }
                            while ($row=mysqli_fetch_array($supResult,MYSQLI_ASSOC)){
                                $supplierID = $row['supplierID'];
                                $canQuery = "INSERT INTO suppliercanvas (supplierID) VALUES ({$supplierID})";
                                $canResult=mysqli_query($dbc,$canQuery);
                                if (!$canResult) {
                                    printf("Error: %s\n", mysqli_error($dbc));
                                    exit();
                                }
                                $canQuery2 = "  SELECT scID
                                                FROM suppliercanvas
                                                ORDER BY 1 DESC
                                                LIMIT 1
                                            ";
                                $canResult2=mysqli_query($dbc,$canQuery2);
                                if (!$canResult2) {
                                    printf("Error: %s\n", mysqli_error($dbc));
                                    exit();
                                }
                                while ($row=mysqli_fetch_array($canResult2, MYSQLI_ASSOC)){
                                    $scID = $row['scID'];
                                }
                                $query = "  
                                        SELECT * 
                                        FROM rsdetails rsd 
                                        JOIN materials m ON rsd.materialID = m.materialID 
                                        JOIN inventory i ON m.materialID = i.materialID
                                        WHERE rsd.urgent = 1
                                        AND rsd.statusID = 9
                                        HAVING SUM(rsd.quantity) > i.quantity
                                        ";
                                $result=mysqli_query($dbc,$query);
                                if (!$result) {
                                    printf("Error: %s\n", mysqli_error($dbc));
                                    exit();
                                }
                                while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                                    $materialID = $row['materialID'];
                                    $rsID = $row['rsDetailsID'];
                                    $scQuery = "INSERT INTO scdetails (scID, materialID, rsDetailsID) VALUES ({$scID}, {$materialID}, {$rsID})";
                                    $scResult=mysqli_query($dbc,$scQuery);
                                    if (!$scResult) {
                                        printf("Error: %s\n", mysqli_error($dbc));
                                        exit();
                                        }
                                }
                            }
                        ?>
                        <h3>Regular</h3>
                        <table class="table">
                          <thead>
                          <tr>
                            <th>Material Name</th>
                            <th>Actual Dimension</th>
                            <th>Quantity Needed</th>
                            <th>Quantity In Stock</th>
                          </tr>
                          </thead>
                          <tbody>
                              <?php
                                $sumQuery = "   SELECT m.materialName, m.actualDimension, SUM(rsd.quantity) AS sumQty, i.quantity
                                                FROM rsdetails rsd 
                                                JOIN materials m ON rsd.materialID = m.materialID 
                                                JOIN inventory i ON m.materialID = i.materialID
                                                AND rsd.statusID = 9
                                                GROUP BY m.materialID
                                                HAVING SUM(rsd.quantity) > i.quantity;
                                            ";
                                $sumResult=mysqli_query($dbc,$sumQuery);
                                if (!$sumResult) {
                                    printf("Error: %s\n", mysqli_error($dbc));
                                    exit();
                                }
                                while ($row=mysqli_fetch_array($sumResult,MYSQLI_ASSOC)){
                                    echo "<tr>";
                                        echo "<td>";
                                        echo $row['materialName'];
                                        echo "</td>";
                                        echo "<td>";
                                        echo $row['actualDimension'];
                                        echo "</td>";
                                        echo "<td>";
                                        echo $row['sumQty'];
                                        echo "</td>";
                                        echo "<td>";
                                        echo $row['quantity'];
                                        echo "</td>";
                                    echo "</tr>";
                                }
                              ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- /.box-body -->
                      
                  </div>
                </div>
                <!-- /.row (main row) -->
          
              </section>
            </div>
        </div>
    </div>
  </div>
  
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="bower_components/raphael/raphael.min.js"></script>
<script src="bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>


<script type = "text/javascript" src = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type = "text/javascript" src = "https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script type = "text/javascript">
$(document).ready(function(){
	$('#example2').DataTable();
});
</script>


</body>
</html>
