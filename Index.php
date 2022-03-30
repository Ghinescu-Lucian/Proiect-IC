<?php 
session_start();

	include("./Functions/connection.php");
	include("./Functions/functions.php");

	$user_data = check_login($con);

?>

<!DOCTYPE html>
<html lang="en" ng-app="main">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./Styles/MenuStyle.css">
    <title>BikeAttack</title>
  </head>
  <body>
    <img class="logo" src="./Imagini/LogoPng.png">
<ul id="menu">
  <ul>
        <center>
    <li><a href="#">Acasa</a></li>
    <li><a href="./components/Biciclete.php">Biciclete</a></li>
    <li><a href="./components/Cos.php">Cosul tau</a></li>
    <?php 
	if($user_data['ID']==0)
	 echo '<li><a href="./components/Login.php">Login</a></li>';
	 else echo '<li><a href="./components/logout.php">Logout</a></li>';
	?>
    </center>
   </ul>
</ul>
<div class="title">
 <h1>Hello, <?php echo $user_data['Username']; ?> !</h1>
</div>
<div class="slider">
</div>
</body>
</html>

