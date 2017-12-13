<?php
  session_start();
  require_once("mysql_connect.php");
  if(isset($_POST['list'])){
    $_SESSION['indivSC'] = $_POST['list'];
    $query = "SELECT supplierID FROM SUPPLIERCANVAS WHERE SCID = ".$_SESSION['indivSC'];
    $result = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $_SESSION['indivSupplier'] = $row['supplierID'];
  }
  $query = "SELECT  S.supplierName, S.contactPerson, S.telephoneNum, S.faxNum, 
            FROM		SUPPLIERS S		JOIN SUPPLIERCANVAS SC 	ON S.SUPPLIERID = SC.SUPPLIERID
                                  JOIN SCDETAILS SCD			ON SCD.SCID = SC.SCID
            WHERE   S.SUPPLIERID = ".$_SESSION['indivSupplier'];
  $result = mysqli_query($dbc, $query);
  
  if(isset($_POST['submit'])){
    $_SESSION['payment'] = $_POST['payment'];
    $_SESSION['account'] = $_POST['account'];
    $_SESSION['accountNumber'] = $_POST['accountNumber'];
    $_SESSION['delivery'] = $_POST['delivery'];
    $_SESSION['poNumber'] = $_POST['poNumber'];
  }
  elseif(isset($_POST['confirm'])){
    // insert to PO
    
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
      $query = "INSERT INTO PURCHASEORDER (poNumber, natureOfDelivery, termsOfPayment, accountName, accountNo, supplierID, statusID)
                VALUES ({$_SESSION['poNumber']}, {$_SESSION['delivery']}, {$_SESSION['payment']}, {$_SESSION['account']}, {$_SESSION['accountNumber']}, {$_SESSION['indivSupplier']}, 4)";
      $result = mysqli_query($dbc, $query);
      
      $query = "SELECT  SCD.scdID
                FROM    SCDETAILS SCD JOIN SUPPLIERCANVAS SC ON SCD.SCID = SC.SCID
                WHERE   SC.SCID = ".$_SESSION['indivSC'];
      $result = mysqli_query($dbc, $query);
      while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $query = "INSERT INTO PODETAILS VALUES ({$_SESSION['poNumber']}, {$_row['scdID']})";
        $result = mysqli_query($dbc, $query);
      }
      $query = "UPDATE PROJECTS SET PSTATUSID = 13 WHERE PROJECTCODE = '".$_SESSION['projectCode'];
      $result = mysqli_query($dbc, $query);
      
      echo "<script>alert('Successfully generated purchase order');</script> ";
      include('mpdf60/mpdf.php');
      $mpdf=new mPDF();
      $mpdf->WriteHTML('<img src="images/logo.png">'.$_POST['string']);
      $mpdf->Output();
      
    }
  }
  
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Purchase Order</title>
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
                <section class="content-header">
                <h1>
                Purchase Order<br>
                <small>Input necessary details to complete and save the purchase order</small>
                </h1>
                <ol class="breadcrumb">
                  <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li class="active">Dashboard</li>
                </ol>
                </section>
                
                <br>
                <!-- INSERT CONTENT HERE -->
                <form action="ph_CreatePO.php" method="POST">
                  <?php
                    if(!isset($_POST['submit'])){
                  ?>
                  <div class="row">
                      <div class="col-xs-4 form-group">
                        <label>Purchase Order Number:</label>
                          <input required type="text" class="form-control" data-inputmask='"mask": "2017-9999"' data-mask name="poNumber" placeholder="2017-0000">
                        <!-- /.input group -->
                      </div>
                      <!-- /.form group -->
                      <div class="col-xs-4 form-group">
                          <label for="input3">Nature of Delivery</label>
                          <select class="form-control" name="delivery">
                            <option selected value="Pickup">Pickup</option>
                            <option value="Deliver to Site">Deliver to Site</option>
                          </select>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-xs-2 form-group">
                          <label for="input2">Account Number</label>
                          <input required name="accountNumber" type="number" class="form-control input" id="input2">
                      </div>
                      <div class="col-xs-4 form-group">
                          <label for="input4">Account Name</label>
                          <input required name="account" type="text" class="form-control input" id="input4" placeholder="Enter account name...">
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-4 form-group">
                      <label for="input4">Payment Terms</label>
                      <input required name="payment" type="text" class="form-control input" id="input5" placeholder="Enter payment terms...">
                    </div>
                  </div>
                  <button type="submit" class="btn btn-success btn-fill" value="submit" name="submit">SUBMIT</button>
                  <?php
                    }
                    
                    else{
                      if($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                  ?>
                  <div id="yes">
                  <div class="box-body">
                      <div class="row">
                          <div class="col-xs-6">
                              <table class="inv">
                                  <tr>
                                      <td>To:</td>
                                  </tr>
                                  <tr>
                                      <td>
                                          <b>Supplier: </b> &nbsp; &nbsp;<b> <?php echo $row['supplierName']; ?></b><br>
                                          <b>Contact Person: </b> <?php echo $row['contactPerson']; ?><br>
                                          <b>Tel. No./ Fax #: </b> <?php
                                              if($row['telephoneNum'] != NULL) echo $row['telephoneNum']." / ";
                                              if($row['cellphoneNum'] != NULL) echo $row['cellphoneNum']." / ";
                                              if($row['faxNum'] != NULL) echo $row['faxNum'];
                                              
                                              } ?>
                                      </td>
                                  </tr>
                              </table>
                          </div>
                          <div class="col-xs-1"></div>
                          <div class="col-xs-4" style="font-size: 16px;">
                              <b>PO Number: </b> <?php echo $_SESSION['poNumber']; ?><br>
                              <b>Date: </b> 13 Jun 17<br>
                              <b>Nature of Delivery: </b> <?php echo $_SESSION['delivery']; ?><br>
                              <b>Terms of Payment: </b> <?php echo $_SESSION['payment']; ?><br>
                              <b>Account Number:</b> <?php echo $_SESSION['accountNumber']; ?><br>
                              <b>Account Name:</b> <?php echo $_SESSION['account']; ?><br>
                          </div>
                      </div>
                      <br>
                      <table class="inv center">
                        <tr>
                            <th rowspan=2>Items</th>
                            <th rowspan=2>MATERIALS<br> Description</th>
                            <th rowspan=2>Actual Dimension</th>
                            <th rowspan=2>Qty</th>
                            <th rowspan=2>Unit</th>
                            <th colspan=3>Price Cost Per Unit Inclusive Of VAT</th>
                            <th colspan=2>TOTAL AMOUNT</th>
                        </tr>
                        <tr>
                            <th>Cost</th>
                            <th>12% VAT</th>
                            <th>Total Cost Per Unit</th>
                            <th>Total E-VAT</th>
                            <th>Inclusive of VAT</th>
                        </tr>
                        <?php
                          $query = "SELECT  M.materialID, M.materialName, M.actualDimension, U.unit, (RD.quantity - I.quantity) AS quantity, SCD.price
                                    FROM    SUPPLIERCANVAS SC JOIN NEEDEDMATERIALS NM ON NM.NEEDEDMATERIALSID = SC.NEEDEDMATERIALSID
                                                              JOIN NMDETAILS NMD      ON NM.NEEDEDMATERIALSID = NMD.NEEDEDMATERIALSID
                                                              JOIN RSDETAILS RD       ON RD.RSDETAILSID = NMD.RSDETAILSID
                                                              JOIN SCDETAILS SCD      ON SC.SCID = SCD.SCID
                                                              JOIN INVENTORY I        ON I.MATERIALID = RD.MATERIALID
                                                              JOIN MATERIALS M        ON SCD.MATERIALID = M.MATERIALID
                                                              JOIN REF_UNITS U        ON M.UNITID = U.UNITID
                                    WHERE   SC.SUPPLIERID = ".$_SESSION['indivSupplier'];
                          $result = mysqli_query($dbc, $query);
                          while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                            echo '<tr>';
                              echo '<td>'.$row['materialID'].'</td>';
                              echo '<td>'.$row['materialName'].'</td>';
                              echo '<td>'.$row['actualDimension'].'</td>';
                              echo '<td>'.$row['quantity'].'</td>';
                              echo '<td>'.$row['unit'].'</td>';
                              echo '<td>'.number_format($row['price'] / 1.12, 2).'</td>';
                              echo '<td>'.number_format($row['price'] / 1.12 * 0.12 , 2).'</td>';
                              echo '<td>'.number_format($row['price'], 2).'</td>';
                              echo '<td>'.number_format($row['price'] / 1.12 * 0.12 * $row['quantity'], 2).'</td>';
                              echo '<td>'.number_format($row['price'] * $row['quantity'], 2).'</td>';
                          }
                        ?>
                      </table>
                      
                      <button type="submit" name="confirm" class="btn btn-fill btn-success">CONFIRM</button>
                      <input type="hidden" name="string" id="string">
                  </div>
                  </div>
                  <?php
                    }
                  ?>
                </form>
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

<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>


<script type = "text/javascript" src = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type = "text/javascript" src = "https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script type = "text/javascript">
$(document).ready(function(){
	$('#example2').DataTable();
});
$('[data-mask]').inputmask();
$('#string').val($('#yes').html());
</script>



</body>
</html>
