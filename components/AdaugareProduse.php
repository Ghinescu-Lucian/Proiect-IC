<?php 
session_start();

	include("../Functions/connection.php");
	include("../Functions/Functions.php");
  
  $user_data = check_login($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../styles/AdaugareProduseStyle.css">
    <title>Ride-bybicycle</title>
	<style>
		#errorMs {
			color: #a00;
		}
		.gallery img{
            width: 300px;
		}
	</style>
</head>
<body>
<ul id="menu"> 
  <ul>
        <center>
    <li><a href="AdaugareProduse.php">Adaugare</a></li>
    <li><a href="Editare.php">Editare</a></li>		
    <li><a href="Comenzi.php">Comenzi</a></li>
    <li><a href="Promotii.php">Promotii</a></li>
	<?php
	if($user_data['ID']==0)
	 echo '<li><a href="Login.php">Login</a></li>';
	 else echo '<li><a href="logout.php">Logout</a></li>';
	?>
    </center>
   </ul>
</ul>
<div class="title">
 <h1>Hello, <?php echo $user_data['Username']; ?> !</h1>
</div>
 <div class="center">
      <h1> Adaugare Produse</h1>
  <form action="../Functions/Upload.php" method="post" enctype="multipart/form-data">
    <div class="txt_field">
            <input name="Nume" type="text" required>
            <span></span>
            <label>Nume</label>
          </div>
        <div class="txt_field">
          <input name="Cantitate" type="text" required>
          <span></span>
          <label>Cantitate</label>
        </div>
        <div class="txt_field">
          <input name="Pret" type="text" required>
          <span></span>
          <label>Pret</label>
        </div>
        <div class="txt_field">
            <span></span>
            <input> <textarea class="ckeditor" name="Descriere" rows=4 cols=45>Bicicleta</textarea>
            <label>Descriere</label>
          </div>
    <input type="file" name="file">
    <input type="submit" name="submit" value="Upload">
  </form>
</div>
<script src="../ckeditor/ckeditor.js"></script>

</body>
</html>