<!DOCTYPE html>
<?php
require_once("mysql_connect.php");
session_start();
$_SESSION['accountID'] = 10000001;

$dont = true;

if (isset($_GET['p'])){
	$phaseID = $_GET['p'];
	$query = "SELECT projectCode FROM phases WHERE phaseID = '".$phaseID."'";
	$result = mysqli_query($dbc, $query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$projectCode = $row['projectCode'];
}

if (isset($_GET['d'])){
	$dont = false;
}

//When adding materials to cart
if (isset($_POST['matSec']) && isset($_POST['spSec']) && isset($_POST['qty'])){
	
			$ss = false;
	if ($_POST['matSec'] != "undefined" && $_POST['spSec'] != "undefined" && $_POST['qty'] != ""){
		$subphaseID = $_POST['spSec'];
		$materialID = $_POST['matSec'];
		$quantity = $_POST['qty'];
		
		$query = "SELECT * from subphases WHERE subphaseID = '".$subphaseID."'";
		$result = mysqli_query($dbc, $query);
		
		if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			$queryy = "SELECT * FROM sp_materials WHERE subphaseID = '".$subphaseID."'";
			$resultt = mysqli_query($dbc, $queryy);
			$ss = false;
			while ($roww = mysqli_fetch_array($resultt, MYSQLI_ASSOC)){
				if ($roww['materialID'] == $materialID){
					if (isset($_SESSION['cart'][$row['subphaseName']])){
						$ctr = 0;
						$stop = false;
						while (isset($_SESSION['cart'][$row['subphaseName']][$ctr])){
							if ($row['subphaseID'] == $subphaseID && $_SESSION['cart'][$row['subphaseName']][$ctr][0] == $materialID){
								$tempQty = $_SESSION['cart'][$row['subphaseName']][$ctr][1] + $quantity;
								if ($roww['quantity'] >= $tempQty){
									$_SESSION['cart'][$row['subphaseName']][$ctr][1] += $quantity;
									$ss = true;
									$statusMessage = "<font color = 'green'><b>Add Success!</b></font>";
									break;
								}
								$stop = true;
							}
							$ctr++;
						}
						if (!$stop){
							array_push($_SESSION['cart'][$row['subphaseName']], array($materialID, $quantity));
							$ss = true;
							$statusMessage = "<font color = 'green'><b>Add Success!</b></font>";
						}
					}
				}
			}
		}
		
	}else{
		$statusMessage = "<font color = 'red'><b>Add Error!</b></font>";
	}
	
	if (!$ss){
		$statusMessage = "<font color = 'red'><b>Add Error!</b></font>";
	}
	$dont = false;
}

//When deleting materials from current cart
if (isset($_POST['deleteMat'])){	
	$materialID = $_POST['matID'];
	$subphaseID = $_POST['spID'];
	$query = "SELECT * from subphases WHERE subphaseID = '".$subphaseID."'";
	$result = mysqli_query($dbc, $query);

	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		if (isset($_SESSION['cart'][$row['subphaseName']])){
			$ctr = 0;
			$stop = false;
			while (isset($_SESSION['cart'][$row['subphaseName']][$ctr])){
				if ($row['subphaseID'] == $subphaseID && $_SESSION['cart'][$row['subphaseName']][$ctr][0] == $materialID){
					unset($_SESSION['cart'][$row['subphaseName']][$ctr]);
					$_SESSION['cart'][$row['subphaseName']] = array_values($_SESSION['cart'][$row['subphaseName']]);
					$stop = true;
					break;
				}
				$ctr++;
			}
		}
	}
	
	$dont = false;
}

//When editing quantity of materials
if (isset($_POST['editQty'])){
	$query = "SELECT * from subphases WHERE phaseID = '".$phaseID."'";
	$result = mysqli_query($dbc, $query);
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		if (isset($_SESSION['cart'][$row['subphaseName']])){
			$ctr = 0;
			while (isset($_SESSION['cart'][$row['subphaseName']][$ctr])){
				$fieldName = "sp".$row['subphaseID']."m".$_SESSION['cart'][$row['subphaseName']][$ctr][0]."";
				$qty = $_POST[$fieldName];
				$_SESSION['cart'][$row['subphaseName']][$ctr][1] = $qty;
				$ctr++;
			}
		}
	}
	//print_r($_SESSION['cart']);
	$dont = false;
}

//creating cart **insert to db**
if (isset($_POST['createRS'])){
	
	$insertQ = "INSERT INTO `requisitionslip` (`projectCode`, `requestedBy`, `dateNeeded`, `rsStatusID`)
	VALUES ('".$projectCode."', '".$_SESSION['accountID']."', '".$_POST['dateNeeded']."', '9')";
	$resultQ = mysqli_query($dbc, $insertQ);
	$rsID = mysqli_insert_id($dbc);
	
	$query = "SELECT * from subphases WHERE phaseID = '".$phaseID."'";
	$result = mysqli_query($dbc, $query);
	$status = false;
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		$ctr = 0;
		while (isset($_SESSION['cart'][$row['subphaseName']][$ctr])){
			
			$materialID = $_SESSION['cart'][$row['subphaseName']][$ctr][0];
			$qty = $_SESSION['cart'][$row['subphaseName']][$ctr][1];
			
			$queryA = "INSERT INTO `rsdetails` (`materialID`, `quantity`, `rsNumber`, `subphaseID`) 
			VALUES ('".$materialID."', '".$qty."', '".$rsID."', '".$row['subphaseID']."')";
			$resultA = mysqli_query($dbc, $queryA);
			if ($resultA){
				$status = true;
			}
			$ctr++;
		}
	}
	//print_r($_SESSION['cart']);
	$dont = false;
	
	if ($status){
		header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/en_requestRS1.php?p=".$phaseID."&r=".$rsID."");
	}else{
		$deleteQ = "DELETE FROM `requisitionslip` WHERE rsNumber = '".$rsID."' ";
		$resultQ = mysqli_query($dbc, $deleteQ);
		
		$Quer = "SELECT MAX(`rsNumber`) AS 'Number' FROM `requisitionslip`";
		$resQuer = mysqli_query($dbc, $Quer);
		$rQuer = mysqli_fetch_array($resQuer, MYSQLI_ASSOC);
		$num = $rQuer['Number'];
		
		$upQ = "ALTER TABLE `requisitionslip` AUTO_INCREMENT = ".$num." ";
		$reQ = mysqli_query($dbc, $upQ);
	}
}

//initializing cart **adds suggested mats to cart**
if (isset($_GET['p'])){
	$phaseID = $_GET['p'];
	if ($dont){
		$query = "SELECT * from subphases WHERE phaseID = '".$phaseID."'";
		$result = mysqli_query($dbc, $query);
		$tempArray = array();
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			$tempArray[$row['subphaseName']] = array();
			$_SESSION['cart'] = $tempArray;
		}
		//print_r($tempArray);
	}
}


?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Create Requisition Slip</title>
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
         <a href="en_assignProjectMembers.php">Assign Project Members</a>
        </li>
        <li>
         <a href="en_createAL.php">Create Accessories List</a>
        </li>
        <li>
         <a href="en_requestRS.php">Request Materials</a>
        </li>
        <li>
         <a href="en_informStatus.php">Inform Project Status</a>
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
				Create Requisition Slip</b><br>
				<small> Input materials </small>
			  </h1>
			  <ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Dashboard</li>
			  </ol>
			</section>
			<?php
			if (isset($status)){
				if (!$status){
					echo'
					<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-ban"></i>FAILED!</h4>
						There\'s an error creating the Requisition Slip.
					</div>';
				}
			}
			?>
                <div class="row">
                    <div class="col-lg-12">
					<br>
                        <div class="col-xs-12">
							<div class="row">
								<div class="col-xs-4">
									<label><h4><b>Project Code: <?php echo $projectCode; ?> </b></h4></label>
								</div>
								
							</div>
							
							<br>
							<form action = "<?php echo "en_requestRS.php?p=".$phaseID.""; ?>" method = "post" id = "InputMat" name = "InputMat">
							<table class = "table table-condensed" style = "width:90%">
							<tr>
							<td><label>Input Materials</label><input type = "hidden" id = "matSec" name = "matSec" value = "">
							</td><td></td>
							</tr>
							<tr>
							<td> 
								<input class = "form-control" list="materials" id = "mats" name = "mats" max ="" value = "" placeholder = "Enter Inventory Name" autocomplete="off" required>
								<datalist id="materials">
								<?php
								$query = "SELECT * FROM materials WHERE materialID IN 
								(SELECT DISTINCT(materialID) FROM sp_materials WHERE subphaseID IN 
								(SELECT subphaseID FROM subphases WHERE phaseID = '".$phaseID."'))";
								$result = mysqli_query($dbc, $query);
								while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
									$str = "";
									$str .= "<option value='";
									$str .= $row['materialName'];
									$str .= " - ".$row['actualDimension']."'"; 
									$str .= ' data-id = "'.$row['materialID'].'"></option>';
									echo $str;
								}
								?>
								</datalist> 
								
							</td>
							<td> <input type = "hidden" id = "spSec" name = "spSec" value = "">
								<input class = "form-control" list="subphases" id = "subph" name = "subph" max ="" value = "" placeholder = "Enter Subphase Name" autocomplete="off" required >
								<datalist id="subphases">
								<?php
								$query = "SELECT * from subphases WHERE phaseID = '".$phaseID."'";
								$result = mysqli_query($dbc, $query);
								while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
									echo '<option value="'.$row['subphaseName'].'" data-id = "'.$row['subphaseID'].'"></option>';
								?>
								</datalist> 
							</td>
							<td style ="width:200px;"> <input class = "form-control" type = "number" min = 1 placeholder = "Input Quantity" name = "qty" required> </td>
							<td> <input type="submit" class="btn btn-block btn-success" id = "AddMats" value = "Add" name ="AddMats"></td>
							</tr>
							<tr>
							<td>
							<?php 
							if (isset($statusMessage)){
								echo $statusMessage;
							}
							?>
							</td>
							</tr>
							</table>
							</form>
							<h4><label>Current Materials:</label></h4>
							<br>
							<form action = "<?php echo "en_requestRS.php?p=".$phaseID.""; ?>" method = "post" id = "InputMat" name = "InputMat">
								
							<!-- Per subphase -->
							<?php
							$query = "SELECT * from subphases WHERE phaseID = '".$phaseID."'";
							$result = mysqli_query($dbc, $query);
							$tempArray = array();
							while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
								echo '<h5><label>'.$row['subphaseName'].'</label></h5>';
								echo '<table class="table table-bordered table-striped" role = "grid">
									<thead>
									<tr role = "row">
										<th style = "text-align:center;" id = "item">Item</th>
										<th>Material</th>
										<th>Actual Dimension</th>
										<th style = "text-align:right;">Quantity</th>
										<th>Unit</th>
										<th></th>
									</tr>
									</thead>
									<tbody>';
									if (isset($_SESSION['cart'][$row['subphaseName']])){
										$ctr = 0;
										$itemnum = 1;
										while (isset($_SESSION['cart'][$row['subphaseName']][$ctr])){
											$queryM = "SELECT * from materials WHERE materialID = '".$_SESSION['cart'][$row['subphaseName']][$ctr][0]."'";
											$resultM = mysqli_query($dbc, $queryM);
											$rowM = mysqli_fetch_array($resultM, MYSQLI_ASSOC);
									
											$queryU = "SELECT * from ref_units WHERE unitID = '".$rowM['unitID']."'";
											$resultU = mysqli_query($dbc, $queryU);
											$rowU = mysqli_fetch_array($resultU, MYSQLI_ASSOC);
											
											if (empty($rowM['actualDimension'])){
												$rowM['actualDimension'] = "-";	
											}
											
											$fieldName = "sp".$row['subphaseID']."m".$rowM['materialID']."";
											echo '
											<tr>
												<td><center> '.$itemnum.' </center></td>
												<td> '.$rowM['materialName'].' </td>
												<td> '.$rowM['actualDimension'].'  </td>
												<td style = "text-align:right;"> '.$_SESSION['cart'][$row['subphaseName']][$ctr][1].' </td>
												<td> '.strtoupper($rowU['unit']).' </td>
												<form method = "post" action = "en_requestRS.php?p='.$phaseID.'">
												<input type = "hidden" name = "matID" value = "'.$rowM['materialID'].'">
												<input type = "hidden" name = "spID" value = "'.$row['subphaseID'].'">
												<td><center><a href = "en_requestRS.php?p='.$phaseID.'"><button type = "submit" class="btn btn-social-icon btn-google" name = "deleteMat"><i class="fa fa-bitbucket"></i></button></a></center></td></form>
											</tr>';
											$itemnum ++;
											$ctr ++;
										}
									}
								echo '		 
									</tbody>
								</table>
								<hr>';
							}
							?></form>
							<button type="button" style = "width:200px; margin:5px;" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-default">
								Create Requisition Slip
							</button>
							<a href = "#"><button type="button" style = "width:100px; margin:5px;" class="btn btn-warning pull-right">Back</button></a>
							
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

<div class="modal modal-default fade" id="modal-default" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><b>Date Needed:</b></h4>
              </div>
			  <form action = "" method = "post">
              <div class="modal-body">
			  <input type = "date" class = "form-control" 
			  <?php
				echo 'min = "'.date("Y-m-d").'" ';
			  ?>
			  id = "dateNeeded" name = "dateNeeded" value = "" required>
			  </div>
              <div class="modal-footer">
				<input type="submit" name = "createRS" class="btn btn-primary" value = "Submit">
				</form>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
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
