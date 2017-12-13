<?php
  session_start();
  // note which userID and projectID from homepage
  include('mpdf60/mpdf.php');
  $_SESSION['projectCode'] = 'EC2/17';
  if(!isset($_SESSION['printed']))
    $_SESSION['printed'] = false;
  
  if(isset($_POST['save']) || isset($_POST['view'])){
    $query = "SELECT  P.projectCode, P.projectName, C.clientName
              FROM    PROJECTS P JOIN CLIENTS C ON P.CLIENTID = C.CLIENTID
              WHERE   P.PROJECTCODE = '".$_SESSION['projectCode'];
    $result = mysqli_query($dbc, $query);
    if($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
      $date = date('m-d-Y');
      $mpdf=new mPDF();
      $mpdf->WriteHTML('<div class="col-xs-6" style="padding: 20px; height: auto;">
                              <img src="images/logo.png">
                              <h2><b>PROJECT TURN OVER</b></h2>
                              <p><b>DATE: '.$date.'</b></p>
                              <p><b>COMPANY: '.$row["clientName"].'</b></p>
                              <p><b>SUBJECT: '.$row["projectName"].' OF '.$row["clientName"].'</b></p>
                              <hr>
                              <p style="text-align: right;"><b>SOM-15V</b></p>
                              <p>We are pleased to inform you that the <b>'.$row["projectName"].' OF '.$row["clientName"].'</b>have been finished
                              as of '.$date.'. We are, therefore, turning over e completed job to you and we would like to take this opportunity to
                              hank you for the job and assistance you have extended to us.</p>
                              <p>Trusting you will find everything in order.</p>
                              <p>Very truly yours,</p>
                              <p><b>WEAL BUILDERS INC.</b></p>
                              <br><br><br>
                              <p>Deogenes J. Tuazon Jr.</p>
                              <p>Engineering Manager-Panel Works</p>
                              <br>
                              <p>Inspected and Accepted by: _________________</p>
                              <br>
                              <p>Date: _______________</p>
                            </div>');
      if(isset($_POST['save'])){
        $mpdf->Output('file.pdf', 'D');
        $_SESSION['printed'] = true;
        exit;
      }
      elseif(isset($_POST['view'])){
        $mpdf->Output();
        $_SESSION['printed'] = true;
      }
    }
  }
  else if(isset($_POST['grant']) && $_SESSION['printed']){
    echo "<script>alert('Successfully turned project over. Will be redirected to homepage in a few...');</script>";
    $query = "UPDATE PROJECTS SET pStatusID = 15 WHERE PROJECTCODE = '".$_SESSION['projectCode']."'";
  }
  

  
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Grant Warranty</title>
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
  
  <style>
    button.btn{
      margin: 5px;
    }
  </style>
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
                  <a href="#" class="btn btn-default btn-flat">Sign out</a>
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
          <font face="Open Sans" size="1" color="white">Admin</font>
        </div>
        <div class="pull-left info">
          
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Link here</span>
          </a>
        </li>
        <li>
          <a href="pages/widgets.html">
            <i class="fa fa-th"></i> <span>Link here</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Link here</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Link here</span>
          </a>
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
                    Grant Turnover<br>
                    <small>Grant project turnover to client when project is finished</small>
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
                        <h3 class="box-title">Grant Turnover</h3>
                      </div>
                    <!-- /.box-header -->
                      <div class="box-body">
                        <div class="col-xs-4">
                          <p><b>Project Name: </b> Something</p>
                          <p><b>Project Code: </b> SOM-15V</p>
                          <p><b>Client: </b> Someone</p>
                          <p><b>Date Started: </b> July 2, 2017</p>
                          <br><br>
                          <p><i>You must save the turnover letter to be able to turnover the project.<br>
                          By turning over the project, you are granting the client a one (1) year warranty and a discount on the bill, reflected
                          by the percentage of completion.</i></p>
                        </div>
                        <div class="col-xs-2"></div>
                        <div class="col-xs-6" style="border: 1px solid #000; padding: 20px; height: auto;">
                          <img src="images/logo.png" style="width: 75%;">
                          <h3><b>TURN OVER</b></h3>
                          <p><b>DATE: January 19, 2018</b></p>
                          <p><b>COMPANY: SOMEONE</b></p>
                          <p><b>ATTENTION: Someone else</b></p>
                          <p><b>SUBJECT: CIVIL WORKS FOR THE PROPOSED EXPANSION OF SOMETHING (5M x 5M)</b></p>
                          <hr>
                          <p style="text-align: right;"><b>SOM-15V</b></p>
                          <p>We are pleased to inform you that the <b>CIVIL WORKS FOR THE PROPOSED EXPANSION OF SOMETHING (5M x 5M)</b>have been finished
                          as of January 19, 2018. We are, therefore, turning over e completed job to you and we would like to take this opportunity to
                          hank you for the job and assistance you have extended to us.</p>
                          <p>Trusting you will find everything in order.</p>
                          <p>Very truly yours,</p>
                          <p><b>WEAL BUILDERS INC.</b></p>
                          <br><br><br>
                          <p>Deogenes J. Tuazon Jr.</p>
                          <p>Engineering Manager-Panel Works</p>
                          <br>
                          <p>Inspected and Accepted by: _________________</p>
                          <br>
                          <p>Date: _______________</p>
                        </div>
                        
                      </div>
                      
                      <form action="ac_GrantTurnover.php" method="post">
                      <!-- /.box-body -->
                        <div class="row">
                          <div class="col-xs-8"></div>
                          <button type="submit" class="btn btn-fill btn-info" name="view">VIEW</button>
                          <button type="submit" class="btn btn-fill btn-success" name="save">SAVE</button></a>
                        </div>
                        <br>
                        <button type="submit" name="grant" class="btn btn-fill btn-success">TURNOVER PROJECT</button>
                        <a href=""><button class="btn btn-fill btn-danger pull-right">BACK TO LIST</button></a>
                      </form>
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
