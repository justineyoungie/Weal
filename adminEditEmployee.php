<?php

session_start();

require_once('mysql_connect.php');

$query="select * from employee where employeeID = " . $_SESSION['employeeID'];
$result=mysqli_query($dbc,$query);

$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

$oldEmployeeFirstName = $row['firstName'];
$oldEmployeeLastName = $row['lastName'];
$eAccountID = $row['accountID'];

if (isset($_POST['submit'])){

$message=NULL;

//pag walang laman yung productname field sa html ilalagay yung message sa $message
//na nakalimutan mo mag enter ng product name

//pag may laman ma sstore sa variable $productname yung inenter mong name ng product sa 
//productname field (dinefine ni sir sa html yung field name as productname)

 if (empty($_POST['firstName'])){
  $firstName=NULL;
  $message.='<p>You forgot to enter the first name!';
 }else
  $firstName=$_POST['firstName'];

  if (empty($_POST['lastName'])){
  $lastName=NULL;
  $message.='<p>You forgot to enter the last name!';
 }else
  $lastName=$_POST['lastName'];

  if (empty($_POST['phone'])){
  $phone=NULL;
  $message.='<p>You forgot to enter the phone number!';
 }else
  $phone=$_POST['phone'];

  if (empty($_POST['emergencyContact'])){
  $emergencyContact=NULL;
  $message.='<p>You forgot to enter the emergency contact!';
 }else
  $emergencyContact=$_POST['emergencyContact'];

  if (empty($_POST['gender'])){
  $gender=NULL;
  $message.='<p>You forgot to enter the gender!';
 }else
  $gender=$_POST['gender'];

  if (empty($_POST['homeAddress'])){
  $homeAddress=NULL;
  $message.='<p>You forgot to enter the home address!';
 }else
  $homeAddress=$_POST['homeAddress'];

  if (empty($_POST['username'])){
  $username=NULL;
  $message.='<p>You forgot to enter the username!';
 }else
  $username=$_POST['username'];

  if (empty($_POST['password'])){
  $password=NULL;
  $message.='<p>You forgot to enter the password!';
 }else
  $password=$_POST['password'];

  if (empty($_POST['email'])){
  $email=NULL;
  $message.='<p>You forgot to enter the email!';
 }else
  $email=$_POST['email'];

  if (empty($_POST['usertypeID'])){
  $usertypeID=NULL;
  $message.='<p>You forgot to enter the usertype!';
 }else
  $usertypeID=$_POST['usertypeID'];

 //pag wala kang nakalimutan na ienter na field
if(!isset($message)){

//yung '../mysql_connect.php' yung directory ng mysql_connect.php mo 
// .. means to go back one level
require_once('mysql_connect.php');
//mag sstore ka ng SQL query sa isang variable tapos
//ipasok mo dun yung values ng bawat variable mo sa form
//gamit ka {$variable} pag numerical
//gamit ka '{$variable}' pag string
//$result is just another variable
//mysqli_query is a method na kung saan kailangan mo ng 
//credentials ng db tapos yung papasok mong query
//pag successful yan gagawa na siya ng record ng product
//then ininsert ni sir yung values ng bawat variable mo sa form sa $message
//para lang malaman mo na kung ano yung ininsert mong product record\
$message="<b><p>Employee: " . $oldEmployeeFirstName . " " . $oldEmployeeLastName . " edited! </b>";
$query="update employee set firstName = '" . $firstName . "' ,
		lastName = '" . $lastName . "' , phone = '" . $phone . "' , emergencyContact = '" . $emergencyContact . "' , 
		gender = '" . $gender . "' , homeAddress = '" . $homeAddress . "' where employeeID = " . $_SESSION['employeeID'];
$result=mysqli_query($dbc,$query);

$query="update accounts set username = '" . $username . "' ,
		password = '" . $password . "' , email = '" . $email . "' , usertypeID = '" . $usertypeID . "' 
		where accountID = " . $eAccountID;
$result=mysqli_query($dbc,$query);

}
 

}/*End of main Submit conditional*/

if (isset($message)){
 echo '<font color="red">'.$message. '</font>';
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Edit Employee</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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
            <i class="fa fa-edit"></i> <span>Create</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Raw Materials</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> Materials</a></li>
			<li><a href="index2.html"><i class="fa fa-circle-o"></i> Suppliers</a></li>
			<li><a href="index2.html"><i class="fa fa-circle-o"></i> Accounts</a></li>
          </ul>
        </li>
		
		<li class="active treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Edit</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Raw Materials</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> Materials</a></li>
			<li><a href="index2.html"><i class="fa fa-circle-o"></i> Suppliers</a></li>
			<li><a href="index2.html"><i class="fa fa-circle-o"></i> Accounts</a></li>
          </ul>
        </li>
        
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="box">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Edit Employee Account<br>
          <small>Edits accounts of employees</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Dashboard</li>
        </ol>
      </section>
  
      <!-- MAIN CONTENT -->
      <section class="content" style="min-height: 750px">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-xs-12">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				
					<?php
						
							if(isset($_GET['submit'])){
								$_SESSION['employeeID'] = $_GET['submit'];
							}
							require_once('mysql_connect.php');

							$query="select * from employee join accounts on employee.accountID = accounts.accountID where employeeID = " . $_SESSION['employeeID'];
							$result=mysqli_query($dbc,$query);
							
							$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
							
						?>
						
					<!-- EMPLOYEE USER NAME -->
                        <div class="col-xs-6 form-group">
                            <label for="input1">Username</label>
                            <?php echo "<input required name='username' type='text' class='form-control input' id='input1' value='{$row['username']}'>";?>
                        </div>
						
						<!-- EMPLOYEE PASSWORD -->
                        <div class="col-xs-6 form-group">
                            <label for="input1">Password</label>
                            <?php echo "<input required name='password' type='password' class='form-control input' id='input1' value='{$row['password']}'>";?>
                        </div>
						 <br><br><br><br>
						 
						<!-- EMPLOYEE FIRST NAME -->
                        <div class="col-xs-6 form-group">
                            <label for="input1">First Name</label>
                            <?php echo "<input required name='firstName' type='text' class='form-control input' id='input1' value='{$row['firstName']}'>";?>
                        </div><br><br><br><br>
						<!-- EMPLOYEE LAST NAME -->
                        <div class="col-xs-6 form-group">
                            <label for="input1">Last Name</label>
                            <?php echo "<input required name='lastName' type='text' class='form-control input' id='input1' value='{$row['lastName']}'>";?>
                        </div><br><br><br><br>
						<!-- GENDER -->
							<div class="col-xs-6 form-group">
								<label>Gender</label>
								<select required class="form-control" name="gender">
									<option value="M">Male</option>
									<option value="F">Female</option>
								</select>
							</div>
						<!-- EMPLOYEE ADDRESS -->
                        <div class="col-xs-8 form-group">
                            <label for="input1">Home Address</label>
                            <?php echo "<input required name='homeAddress' type='text' class='form-control input' id='input1' value='{$row['homeAddress']}'>";?>
                        </div>
						<!-- EMPLOYEE EMAIL -->
                        <div class="col-xs-6 form-group">
                            <label for="input1">E-mail</label>
                            <?php echo "<input required name='email' type='text' class='form-control input' id='input1' value='{$row['email']}'>";?>
                        </div><br><br><br><br><br><br><br><br><br><br><br><br>
						<!-- EMPLOYEE TITLE -->
                        <div class="col-xs-6 form-group">
								<label>Employee Title</label>
								<select class="form-control" name="usertypeID">
									<?php
										require_once('mysql_connect.php');

										$query="select * from ref_usertype";
										$result=mysqli_query($dbc,$query);
										
										while($row2=mysqli_fetch_array($result,MYSQLI_ASSOC)){
											echo "<option value={$row2['usertypeID']}>{$row2['usertype']}</option>";
										}
									?>
								</select>
							</div>
						<!-- PHONE NUMBER -->
                        <div class="col-xs-8 form-group">
                            <label for="input2">Phone Number</label>
                            <?php echo "<input required name='phone' type='text' class='form-control input' id='input1' value='{$row['phone']}'>";?>
                        </div>
						<!-- EMERGENCY CONTACT NUMBER -->
                        <div class="col-xs-8 form-group">
                            <label for="input2">Emergency Contact Number</label>
                            <?php echo "<input required name='emergencyContact' type='text' class='form-control input' id='input1' value='{$row['emergencyContact']}'>";?>
                        </div>
						
						<!-- CREATE BUTTON -->
						<div class="col-xs-8 form-group">
							<input type="submit" name="submit">
							<a href="adminEmployeeList.html"><button>Back</button></a>
							</div>
						
					</form>
				</div>
					
            </div>
			
        </div>
		
        <!-- /.row (main row) -->
  
      </section>
	                      </div>
      <!-- END OF MAIN CONTENT -->
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
</body>
</html>
