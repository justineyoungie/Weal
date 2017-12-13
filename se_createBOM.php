
<?php
  session_start();
  require_once('mysql_connect.php');
  
  if(isset($_POST['serviceSubmit'])){
    $_SESSION['phaseNum'] = array();
    $_SESSION['category'] = array();
    $_SESSION['subphase'] = array();
    $_SESSION['totalCost'] = array();
    $query = "SELECT  RP.phaseNum, RP.phaseName, RS.subphaseName, RS.totalCost
              FROM    REF_PHASES RP JOIN REF_SUBPHASES RS ON RP.PHASEID = RS.PHASEID
              WHERE   RP.SERVICETYPEID = ".$_POST['service'];
    $result = mysqli_query($dbc, $query);
    $i = 1;
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
      array_push($_SESSION['phaseNum'], $i);
      array_push($_SESSION['category'], $row['phaseName']);
      array_push($_SESSION['subphase'], $row["subphaseName"]);
      array_push($_SESSION['totalCost'], $row['totalCost']);
      $i++;
    }
  }
  elseif(isset($_POST['subphase'])){
    if(!in_array($_POST['categoryName'],$_SESSION['category'])){
      array_push($_SESSION['phaseNum'], sizeof($_SESSION['phaseNum']) + 1);
    }
    if(in_array($_POST['categoryName'], $_SESSION['category'])){
            
    }
    else{
      array_push($_SESSION['category'], $_POST['categoryName']);
      array_push($_SESSION['subphase'], $_POST['subcategory']);
      array_push($_SESSION['totalCost'], $_POST['cost']);
    }
    
  }
  elseif(isset($_POST['clear'])){
    $_SESSION['phaseNum'] = array();
    $_SESSION['category'] = array();
    $_SESSION['subphase'] = array();
    $_SESSION['totalCost'] = array();
  }
  elseif(isset($_POST['submit'])){
        $previous = "";
        $lastID = 0;
        for($i = 0; $i < sizeof($_SESSION['category']); $i++){
          if($previous != $_SESSION['category'][$i]){
            $query = "INSERT INTO phases (phaseName, phaseNum, projectCode, statusID)
                      VALUES ({$_SESSION['category'][$i]}, {$_SESSION['phaseNum'][$i]}, {$_SESSION['projectCode']}, 4";
            echo $query;
            $result = mysqli_query($dbc, $query);
            $lastID = mysql_insert_id();
            
          }
          
          $query = "INSERT INTO subphases (phaseID, subphaseName, subphaseNum, totalCost)
                    VALUES ({$lastID}, {$_SESSION['subphase'][$i]}, {$i}, {$_SESSION['totalCost'][$i]})";
          $result = mysqli_query($dbc, $query);
          echo $query;
          $previous = $_SESSION['category'][$i];
        }
        $query = "UPDATE PROJECTS SET PSTATUSID = 4 WHERE PROJECTCODE = ".$_SESSION['projectCode'];
        $result = mysqli_query($dbc, $query);
        
        echo "<script>alert('Successfully created the Bill of Quantities!'); </script>";
        
        $_SESSION['phaseNum'] = array();
        $_SESSION['category'] = array();
        $_SESSION['subphase'] = array();
        $_SESSION['totalCost'] = array();
      
  }
  
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>BOM - Create BOM</title>
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
  <!-- sidebar -->
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
            <a href="se_NTP.php">Create Notice to Proceed</a>
        </li>
        <li>
            <a href="se_createBOM.php">Create Bill of Materials</a>
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
            <div class="box">
			<section class="content-header">
        <h1>
          Create BOM
        </h1>
			  <ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Dashboard</li>
			  </ol>
			</section>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-xs-12">
                        
                         <center><h2> Bill of Quantities </h2></center>
                            <form class="form-horizontal" method="post" action="se_createBOM.php">
                              <div class="tab-content">
                                <div id="menu1" class="tab-pane fade in active">
                                  <div class="row">
                                    <div class="col-xs-6">
                                      <select name="service" class="form-control">
                                        <?php
                                          $query = "SELECT servicetype, servicetypeID FROM REF_SERVICETYPE";
                                          $result = mysqli_query($dbc, $query);
                                          while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                            echo "<option value='".$row['servicetypeID']."'>".$row['servicetype']."</option>";
                                          }
                                        ?>
                                      </select>
                                      <button type="submit" name="serviceSubmit" class="btn btn-fill btn-warning">SUBMIT</button>
                                    </div>
                                  </div>
                            </form>
                            <form class="form-horizontal" method="post" action="se_createBOM.php">
                                  <h4>Add Subphase</h4>
                                  <div class="row">
                                      <div class="col-xs-4">
                                        <label>Phase</label>
                                        <input type="hidden" name="category">
                                        <input required list="categorylist" id="inventory" placeholder="Enter phase name..." class="form-control" autocomplete="off" name="categoryName">
                                        <datalist id="categorylist">
                                          <?php
                                            for($i = 0; $i < sizeof($_SESSION['category']); $i++){
                                              echo "<option value='".$_SESSION['category'][$i]."'></option>";
                                            }
                                          ?>
                                        </datalist>
                                    </div>
                                    <div class="col-xs-4">
                                        <label>Subcategories</label>
                                        <input type="hidden" name="materials">
                                        <input required list="subcategorylist" id="subcategory" placeholder="Enter subcategory name..." class="form-control" autocomplete="off" name="subcategory">
                                        <datalist id="subcategorylist">
                                          <?php
                                            $query = "SELECT subphaseName FROM SUBPHASES";
                                            $result = mysqli_query($dbc, $query);
                                            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                              echo "<option value='".$row['subphaseName']."'></option>";
                                            }
                                          ?>
                                        </datalist>
                                    </div>
                                    <div class="col-xs-2">
                                        <label>Cost</label>
                                        <input required type="number" class="form-control" placeholder="Enter subphase cost..." step="0.01" name="cost">
                                        <button type="submit" class="btn btn-default" id ="addMaterial" style="float: right" name="subphase">SUBMIT SUBCATEGORY</button
                                    </div>
                                  </div>
                                </div>
                              </div>      
                          </form>
                          <center><h3>Current Materials</h3></center>
                              <table id="tableItems" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                  <th>Item No.</th>
                                  <th>Name</th>
                                  <th>Total Cost</th>
                                  <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $previous = "";
                                    for($i = 0; $i < sizeof($_SESSION['category']); $previous = $_SESSION['category'][$i], $i++ ){
                                      if($previous != $_SESSION['category'][$i]){
                                        echo '<tr>';
                                          echo '<td bgcolor="#EEEEEE">'.$_SESSION['phaseNum'][$i].'</td>';
                                          echo '<td bgcolor="#EEEEEE" colspan="2">'.$_SESSION['category'][$i].'</td>';
                                          echo '<td bgcolor="#EEEEEE"><button class="btn btn-default">X</button></td>';
                                        echo '</tr>';
                                      }
                                      echo '<tr>';
                                      echo '<td><p align="center"></p></td>';
                                      echo '<td>'.$_SESSION['subphase'][$i].'</td>';
                                      echo '<td><p align="right">'.number_format($_SESSION['totalCost'][$i], 2).'</p></td>';
                                      echo '<td><button class="btn btn-default">X</button></td>';
                                      echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                              </table>
                          <form action="se_createBOM.php" method="post">
                            <input type="submit" value="CLEAR BOM" class="btn btn-danger btn-fill pull-right" name="clear">
                            <input type="submit" value="CREATE BOM" class="btn btn-success btn-fill pull-right" name="submit">
                          </form>
                       </div>
                    </div>
                </div>    
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

  
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
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
<!-- Data Table -->
<script type = "text/javascript">
$(document).ready(function(){
	$('#tableItems').DataTable();
});
</script>
    
<!-- Adding of Materials in PHP -->
<script type="text/javascript">
$("addMaterial").click(function(){
  var value= $(this).getAttr("data-value");
  document.getElementsByName("materials")[0].value = value;
})
</script>
</body>
</html>

