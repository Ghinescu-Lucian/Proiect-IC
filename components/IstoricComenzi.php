<?php 
session_start();

	include("../Functions/connection.php");
	include("../Functions/functions.php");
    include("../Functions/function2.php");

	$user_data = check_login($con);
    $orders_data= getOrdersUser($con,$user_data["Username"]);
    if(isset($_POST["Detalii"]))
	  {
		$idComanda = $_POST['idOrder'];
    $querry = " Select * from orders where idOrder = $idComanda";
    $result = mysqli_query($con, $querry);
    $order_data = mysqli_fetch_assoc($result);
    $detalii="ID: ".$order_data['idOrder']."&#13;&#10;";
    $detalii=$detalii."User: ".$order_data['Username']."&#13;&#10;";
    $detalii=$detalii."Nume: ".$order_data['Nume']."&#13;&#10;";
    $detalii=$detalii."Pret: ".$order_data['Pret']."&#13;&#10;";
    $detalii=$detalii."Telefon: ".$order_data['nrTelefon']."&#13;&#10;";
    $detalii=$detalii."Data: ".$order_data['Data']."&#13;&#10;";
    $detalii=$detalii."Detalii: ".$order_data['Detalii']."&#13;&#10;";
    $_SESSION['Detalii']  = $detalii;
    $_SESSION['Status'] = $order_data['Status'];
    $_SESSION['idComanda'] = $idComanda;
  }

?>
<html lang="en" ng-app="main">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../Styles/ComenziStyle.css">
    <title>BikeAttack</title>
    <style>
        table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
        }

        tr:nth-child(even) {
        background-color: #dddddd;
        }
    </style>
  </head>
  <body>
  <h2><a href="Cos.php">Inapoi</a></h2>
  <div class="center">
      <h1>Detalii </h1>
  <form enctype="multipart/form-data">
  
          <div class="txt_field">
          <input><textarea name="Descriere" rows=10 cols=90><?php if($_SESSION["idComanda"]) echo $_SESSION['Detalii']; else echo "1234"; ?></textarea>
          <span></span>
            <label>Detalii</label>
          </div>
          <div class="txt_field">
            <input name="Status" type="text" value="<?php if($_SESSION["idComanda"]) echo $_SESSION['Status']; ?>">
            <span></span>   
            <label>Status</label>
          </div>
  </form>
</div>
  <table class="orders">
    <thead>
        <tr>
          <th>Id</th>
          <th>Total</th>
          <th>User</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
  <?php
    if ($orders_data->num_rows > 0) {
        // output data of each row
        while($row = $orders_data->fetch_assoc()) {
        //  echo 'ID: ' .$row["idProduct"] ;
        if(empty($row['Status'])) $row['Status']="In procesare";
        echo '
        <tr>
            <td>'.$row['idOrder'].'</td>
            <td>'.$row['Pret'].' lei</td>
        
            <td>'.$row['Username'].'</td>
            <td>'.$row['Status'].'</td>
            <td>  
            <form method="POST">
                <input type="hidden" name="idOrder" value="'.$row["idOrder"].'" />
                <input type="submit" name="Detalii" class="add-cart-btn" value="Detalii"/>
            </form> 
            </td>
        </tr>
        ';
        }
    }
    ?>
    </tbody>
    </table>
  </body>
</html>
