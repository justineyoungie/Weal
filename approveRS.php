<!DOCTYPE html>
<?php
require_once("mysql_connect.php");
session_start();
$dont = true;
$_SESSION['accountID'] = 10000003;

if (isset($_GET['r'])){
	$rsID = $_GET['r'];
	$notYet = true;
	
	$query = "SELECT subphaseID FROM rsdetails WHERE rsNumber = '".$rsID."'";
	$result = mysqli_query($dbc, $query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$subphaseID = $row['subphaseID'];
	
	$query = "SELECT phaseID FROM subphases WHERE subphaseID = '".$subphaseID."'";
	$result = mysqli_query($dbc, $query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$phaseID = $row['phaseID'];
	
	$query = "SELECT projectCode FROM phases WHERE phaseID = '".$phaseID."'";
	$result = mysqli_query($dbc, $query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$projectCode = $row['projectCode'];
	
	$query = "SELECT * FROM requisitionslip WHERE rsNumber = '".$rsID."'";
	$result = mysqli_query($dbc, $query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	if ($row['requestedBy'] != $_SESSION['accountID']){
		if (!empty($row['recommendedBy'])){
			if ($row['recommendedBy'] == $_SESSION['accountID']){
				$notYet = false;
			}
		}else if (!empty($row['verifiedBy'])){
			if ($row['verifiedBy'] == $_SESSION['accountID']){
				$notYet = false;
			}
		}else if (!empty($row['approvedBy'])){
			if ($row['approvedBy'] == $_SESSION['accountID']){
				$notYet = false;
			}
		}
	}else{
		$notYet = false;
	}
	
	$sql = "SELECT * FROM docu_approval where accountID = '".$_SESSION['accountID']."' AND docutypeID = '2' ";
	$esql = mysqli_query($dbc, $sql);
	$rsql = mysqli_num_rows($esql);
	if ($rsql == 0){
		$notYet = false;
	}
	
}

if (isset($_GET['st'])){
	$stat = $_GET['st'];
	if ($stat == "a"){
		$message = '<div class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-check"></i> Requisition Slip Approved!</h4>
					You have successfully approved a Requisition Slip.
				</div>';
	}else{
		$message = '<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-ban"></i>Disapproved Requisition Slip!</h4>
						Requisition Slip Disapproved!
					</div>';
	}
}

if (isset($_POST['recommend'])){
	$query = "SELECT * FROM requisitionslip WHERE rsNumber = '".$rsID."'";
	$result = mysqli_query($dbc, $query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	if (empty($row['recommendedBy'])){
		$query1 = "UPDATE `requisitionslip` SET recommendedBy = '".$_SESSION['accountID']."' WHERE rsNumber = '".$rsID."'";
		$result1 = mysqli_query($dbc, $query1);
	}
	if ($result1){
		header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/approveRS.php?r=".$rsID."&st=a");
	}
}

if (isset($_POST['verify'])){
	$query = "SELECT * FROM requisitionslip WHERE rsNumber = '".$rsID."'";
	$result = mysqli_query($dbc, $query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	if (empty($row['verifiedBy'])){
		$query1 = "UPDATE `requisitionslip` SET verifiedBy = '".$_SESSION['accountID']."' WHERE rsNumber = '".$rsID."'";
		$result1 = mysqli_query($dbc, $query1);
	}
	if ($result1){
		header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/approveRS.php?r=".$rsID."&st=a");
	}
}

if (isset($_POST['approve'])){
	$query = "SELECT * FROM requisitionslip WHERE rsNumber = '".$rsID."'";
	$result = mysqli_query($dbc, $query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	if (empty($row['approvedBy'])){
		$query1 = "UPDATE `requisitionslip` SET approvedBy = '".$_SESSION['accountID']."' WHERE rsNumber = '".$rsID."'";
		$result1 = mysqli_query($dbc, $query1);
	}
	if ($result1){
		header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/approveRS.php?r=".$rsID."&st=a");
	}
}

if (isset($_POST['disapproved'])){
	$query1 = "UPDATE `requisitionslip` SET reason = '".$_POST['reason']."', statusID = '6', disapprovedBy = '".$_SESSION['accountID']."' WHERE rsNumber = '".$rsID."'";
	$result1 = mysqli_query($dbc, $query1);
	if ($result1){
		header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/approveRS.php?r=".$rsID."&st=d");
	}
}


?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Approve Requisition Slip</title>
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
		<li>
          <a href="pages/widgets.html">
            <i class="fa fa-edit"></i> <span>Create Bill of Materials</span>
            
          </a>
        </li>

		<li>
          <a href="pages/widgets.html">
            <i class="fa fa-edit"></i> <span>Create Accessories List <b><font size="3">(AL)</b></font></span>
            
          </a>
        </li>
		<li>
          <a href="pages/widgets.html">
            <i class="fa fa-edit"></i> <span>Adjust AL</span>
            
          </a>
        </li>
		<li>
          <a href="pages/widgets.html">
            <i class="fa fa-check"></i> <span>Check AL</span>
            
          </a>
        </li>
		<li>
          <a href="pages/widgets.html">
            <i class="fa fa-check"></i> <span>Approve AL</span>
            
          </a>
        </li>
		<li>
          <a href="pages/widgets.html">
            <i class="fa fa-edit"></i> <span>Create Requisition Slip <b><font size="3">(RS)</b></font></span>
            
          </a>
        </li>
		<li>
          <a href="pages/widgets.html">
            <i class="fa fa-clone"></i> <span>Compare AL with RS</span>
            
          </a>
        </li>
		<li>
          <a href="pages/widgets.html">
            <i class="fa fa-check"></i> <span>Verify Purchase Order</span>
            
          </a>
        </li>
		<li>
          <a href="pages/widgets.html">
            <i class="fa fa-edit"></i> <span>Create Whereabouts Slip</span>
            
          </a>
        </li>
		<li>
          <a href="pages/widgets.html">
            <i class="fa fa-edit"></i> <span>Create Transfer Request</span>
            
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
		<?php if (isset($show)) echo $show; ?>
            <div class="box">
			<section class="content-header">
			  <h1><b>
				Approve Requisition Slip</b><br>
				<br>
			  </h1>
			  <ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Dashboard</li>
			  </ol>
			</section>
			<?php if (isset($message)){
				echo $message;
			}?>
                <div class="row">
                    <div class="col-lg-12">
					<br>
                        <div class="col-xs-12">
							<div class="row">
								<div class="col-xs-6">
									<h2><b>R.S. Number:</b> <?php echo $rsID; 
									
									$queryB = "SELECT * FROM requisitionslip WHERE rsNumber = '".$rsID."';";
									$resultB = mysqli_query($dbc, $queryB);
									$rowB = mysqli_fetch_array($resultB, MYSQLI_ASSOC);
									
									?></h2>
								</div>
								<div class="col-xs-6">
									<h2><b>Status: </b> <span class="label label-warning" style = "font-size:20px;">
									
									<?php
									$querX = "SELECT * FROM ref_status WHERE statusID = '".$rowB['rsStatusID']."' ";
									$resulX = mysqli_query($dbc, $querX);
									$roX = mysqli_fetch_array($resulX, MYSQLI_ASSOC);
									echo ucfirst($roX['status']);

									?>
									
									</span> </h2> <h3></h3>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6">
									<label><h4><b>Project Code: <?php echo $projectCode; ?> </b></h4></label>
								</div>
							  <div class="col-xs-6">
								<h4><b>Accessories List Name: </b> 
								<?php
									$query = "SELECT * FROM phases WHERE phaseID = '".$phaseID."';";
									$result = mysqli_query($dbc, $query);
									$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
									
									echo $row['phaseName'];
								?>
								</h4>
							  </div>
							</div>
							<div class="row">
							  <div class="col-xs-6">
								<b>Project Name: </b> 
								<?php 
								$queryP = "SELECT * FROM projects WHERE projectCode = '".$projectCode."';";
								$resultP = mysqli_query($dbc, $queryP);
								$rowP = mysqli_fetch_array($resultP, MYSQLI_ASSOC);
								
								echo $rowP['projectName']; ?>
							  </div>
							  <div class="col-xs-6">
							  </div>
							</div>
							
							<div class="row">
							  <div class="col-xs-6">
								<b>Requested by: </b> 
								<?php 
									$queryE = "SELECT * FROM employee WHERE accountID = '".$rowB['requestedBy']."'";
									$resultE = mysqli_query($dbc, $queryE);
									$rowE = mysqli_fetch_array($resultE, MYSQLI_ASSOC);
									
									echo "".ucfirst($rowE['firstName'])." ".ucfirst($rowE['lastName'])."";
								?>
							  </div>
							  <div class="col-xs-6">
								<b>Date Created: </b> <?php echo $rowB['dateRequested']; ?>
							  </div>
							</div>
							
							<div class="row">
							  <div class="col-xs-6">
								<b>Location: </b> <?php echo $rowP['whLocation']; ?>
							  </div>
							  <div class="col-xs-6">
								<b>Date Needed: </b> <?php echo $rowB['dateNeeded']; ?>
							  </div>
							</div>
							
							<br>
							
							<!-- Per subphase -->
							<?php
							$query = "SELECT * from subphases WHERE phaseID = '".$phaseID."'";
							$result = mysqli_query($dbc, $query);
							
							while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
								$queryA = "SELECT * FROM rsdetails WHERE subphaseID = '".$row['subphaseID']."'";
								$resultA = mysqli_query($dbc, $queryA);
								
								$itemnum = 1;
								
								
								if (mysqli_num_rows($resultA)!= 0){
									echo '<h5><label>'.$row['subphaseName'].'</label></h5>';
									echo '<table class="table table-bordered table-striped" role = "grid">
									<thead>
									<tr role = "row">
										<th style = "text-align:center;" id = "item">Item</th>
										<th>Material</th>
										<th>Actual Dimension</th>
										<th style = "text-align:right;">Quantity</th>
										<th>Unit</th>
										</tr>
									</thead>
									<tbody>';
								}
								
								while ($rowA = mysqli_fetch_array($resultA, MYSQLI_ASSOC)){
									
									$queryM = "SELECT * from materials WHERE materialID = '".$rowA['materialID']."'";
									$resultM = mysqli_query($dbc, $queryM);
									$rowM = mysqli_fetch_array($resultM, MYSQLI_ASSOC);
							
									$queryU = "SELECT * from ref_units WHERE unitID = '".$rowM['unitID']."'";
									$resultU = mysqli_query($dbc, $queryU);
									$rowU = mysqli_fetch_array($resultU, MYSQLI_ASSOC);
									
									if (empty($rowM['actualDimension'])){
										$rowM['actualDimension'] = "-";	
									}
									
									echo '
									<tr>
										<td><center> '.$itemnum.' </center></td>
										<td> '.$rowM['materialName'].' </td>
										<td> '.$rowM['actualDimension'].'  </td>
										<td style = "text-align:right;"> '.$rowA['quantity'].' </td>
										<td> '.strtoupper($rowU['unit']).' </td>
										</tr>';
									$itemnum ++;
								}
								echo '		 
									</tbody>
								</table>';
							}
							$query = "SELECT * FROM phases WHERE phaseID = '".$phaseID."';";
							$result = mysqli_query($dbc, $query);
							$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
							if ($row['statusID'] == 5 || $row['statusID'] == 6){
								$stas = true;
							}else{
								$stas = false;
							}
							
							$sql = "SELECT * FROM docu_approval where accountID = '".$_SESSION['accountID']."' AND docutypeID = '2' ";
							$esql = mysqli_query($dbc, $sql);

							$query = "SELECT * FROM requisitionslip WHERE rsNumber = '".$rsID."'";
							$result = mysqli_query($dbc, $query);
							$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
															
							while ($rsql = mysqli_fetch_array($esql, MYSQLI_ASSOC)){
								if (empty($row['recommendedBy']) && $rsql['approveID'] == '5'){
									
								}else if (empty($row['verifiedBy']) && $rsql['approveID'] == '2'){
								
								}else if (empty($row['approvedBy']) && $rsql['approveID'] == '3'){
									
								}else{
									$notYet = false;
								}
							}
							
							if (!isset($stat) && !$stas && $notYet){
								echo '
								<form action = "approveRS.php?&r='.$rsID.'" method = "post">
								<input type="submit" name = "';
								
								$sql = "SELECT * FROM docu_approval where accountID = '".$_SESSION['accountID']."' AND docutypeID = '2' ";
								$esql = mysqli_query($dbc, $sql);
	
								$query = "SELECT * FROM requisitionslip WHERE rsNumber = '".$rsID."'";
								$result = mysqli_query($dbc, $query);
								$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
															
								while ($rsql = mysqli_fetch_array($esql, MYSQLI_ASSOC)){
									if (empty($row['recommendedBy']) && $rsql['approveID'] == '5'){
										echo "recommend";
									}else if (empty($row['verifiedBy']) && $rsql['approveID'] == '2'){
										echo "verify";
									}else if (empty($row['approvedBy']) && $rsql['approveID'] == '3'){
										echo "approve";
									}
								}
								
								echo'" style = "width:150px; margin:5px;" class="btn btn-success pull-right" value = "'; 
								
								$sql = "SELECT * FROM docu_approval where accountID = '".$_SESSION['accountID']."' AND docutypeID = '2' ";
								$esql = mysqli_query($dbc, $sql);
	
								$query = "SELECT * FROM requisitionslip WHERE rsNumber = '".$rsID."'";
								$result = mysqli_query($dbc, $query);
								$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
																
								while ($rsql = mysqli_fetch_array($esql, MYSQLI_ASSOC)){
									if (empty($row['recommendedBy']) && $rsql['approveID'] == '5'){
										echo "Recommend";
									}else if (empty($row['verifiedBy']) && $rsql['approveID'] == '2'){
										echo "Verify";
									}else if (empty($row['approvedBy']) && $rsql['approveID'] == '3'){
										echo "Approve";
									}
								}
								
								echo'">
								</form>
								<button type="button" style = "width:150px; margin:5px;" class="btn btn-danger pull-right" data-toggle="modal" data-target="#modal-danger">
									Disapprove
								</button>';
							}
							else{
								echo '<a href = "#.html"><button type="button" style = "width:100px; margin:5px;" class="btn btn-warning pull-right">Back</button></a>
								';
							}
							
							?>
							<br>
							<hr>
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

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
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

<!-- Modals -->
<div class="modal modal-danger fade" id="modal-danger" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><b>Reason for Disapproval</b></h4>
              </div>
			  <form action = "" method = "post">
              <div class="modal-body">
			  <input type = "text" id = "reason" name = "reason" minlength = "10" class="form-control" placeholder="Enter Reason..." required>
              </div>
              <div class="modal-footer">
				<input type="submit" name = "disapproved" class="btn btn-outline" value = "Submit">
				</form>
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
<!-- Modals -->

<script type = "text/javascript" src = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type = "text/javascript" src = "https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script type = "text/javascript">
$(document).ready(function(){
	$('#example2').DataTable();
});


$("#AddMats").click(function(){
var smth = $("#materials option[value='" + $('#mats').val() + "']").attr('data-id');
document.getElementById('matSec').value = smth;
var smth1 = $("#subphases option[value='" + $('#subph').val() + "']").attr('data-id');
document.getElementById('spSec').value = smth1;
document.getElementById('InputMat').submit();
});
</script>

</body>
</html>
