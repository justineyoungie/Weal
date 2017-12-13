<?php
//lagi ka maglalagay ng session_start(); sa unang line ng <?php mo
//pati yung require_once('../mysql_connect.php');

session_start();

//pag na click si submit button which is name niya = 'submit' (dinefine ni sir sa html
//as submit)
if (isset($_POST['submit'])){

//nagdeclare lang siya ng message variable for later
$message=NULL;

//pag walang laman yung productname field sa html ilalagay yung message sa $message
//na nakalimutan mo mag enter ng product name

//pag may laman ma sstore sa variable $productname yung inenter mong name ng product sa 
//productname field (dinefine ni sir sa html yung field name as productname)
 if (empty($_POST['username'])){
  $username=NULL;
  $message.='<p>You forgot to enter the user name!';
 }else
  $username=$_POST['username'];

 if (empty($_POST['password'])){
  $password=NULL;
  $message.='<p>You forgot to enter the password!';
 }else
  $password=$_POST['password'];
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
//para lang malaman mo na kung ano yung ininsert mong product record

$query="select * from accounts where username = '" . $username ."' and password = '" . $password . "'"; 
$result=mysqli_query($dbc,$query);

if($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
	$_SESSION['usertypeID'] = $row['usertypeID'];
	$_SESSION['accountID'] = $row['accountID'];
	
	if($_SESSION['usertypeID'] == 100){
		header("Location: adminCreateMaterials.html"); /* Redirect browser */
		exit();
	}
	
	if($_SESSION['usertypeID'] == 101){
		header("Location: en_Homepage.php"); /* Redirect browser */
		exit();
	}
	
	if($_SESSION['usertypeID'] == 102){
		header("Location: sa_Homepage.php"); /* Redirect browser */
		exit();
	}
	
	if($_SESSION['usertypeID'] == 103){
		header("Location: se_NTP.php"); /* Redirect browser */
		exit();
	}
	
	if($_SESSION['usertypeID'] == 104){
		header("Location: wh_Homepage.php"); /* Redirect browser */
		exit();
	}
	
	if($_SESSION['usertypeID'] == 105){
		header("Location: gm_Homepage.php"); /* Redirect browser */
		exit();
	}
	
	if($_SESSION['usertypeID'] == 106){
		header("Location: ph_Homepage.php"); /* Redirect browser */
		exit();
	}
	
	if($_SESSION['usertypeID'] == 107){
		header("Location: eh_ProjectList.php"); /* Redirect browser */
		exit();
	}
}
else{
	$message="<b><p>Invalid login!</b>";
}

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
  <title>Weal Builders Inc. | Log in</title>
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
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index2.html"><b>Weal</b> Builders Inc.</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="login.php" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Username" name="username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" name="submit">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <!-- /.social-auth-links -->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>

