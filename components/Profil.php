<?php 
session_start();

	include("../Functions/connection.php");
	include("../Functions/Functions.php");

//read from database
$user_data=check_login($con);
//$query = "select * from users where Username = '$Username' limit 1";
// $result = mysqli_query($con, $query);

//while($user_data = $result->fetch_assoc()) {
  $ID=$user_data["ID"];
  $Nume=$user_data["Nume"];
  $Email=$user_data["Email"];
//}

if(!$user_data){

echo "wrong username or password!";
}
  
?>

<!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/codingnepal -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Ride-By-Bicycle</title>
    <link rel="stylesheet" href="../Styles/Profile.css">
  </head>
  <body>
    <?php 
    echo '<h2>'. $Nume .'s profile</h2><br />
    <table>
      <tr><td>ID:</td><td>'.$ID.'</td></tr>
      <tr><td>Name:</td><td>'.$Nume.'</td></tr>
      <tr><td>Email:</td><td>'.$Email.'</td></tr>
</table>
    ';
    ?>
    <!-- <h2><?php echo $Nume; ?>s profile</h2><br />
    <table>
      <tr><td>ID:</td><td><?php echo $ID; ?></td></tr>
      <tr><td>Name:</td><td><?php echo $Nume; ?></td></tr>
      <tr><td>Email:</td><td><?php echo $Email; ?></td></tr>
</table> -->

  </body>
</html>
