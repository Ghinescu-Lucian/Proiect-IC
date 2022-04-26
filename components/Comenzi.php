<?php 
session_start();

	include("../Functions/connection.php");
	include("../Functions/functions.php");
    include("../Functions/function2.php");

   	$user_data = check_login($con);
         $orders_data= getOrders($con);

    if(isset($_POST["cauta"])){
      $keyword= $_POST["keyword"];
      $tmp= getOrdersKey($con,$keyword);
      if($tmp)
        $orders_data=$tmp;
      else
        echo "<script>alert('Cuvant inexistent!')</script>";  
    }

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" href="../Styles/ComenziStyle.css">
    <link rel="stylesheet" href="../Styles/BicicleteStyle.css">

    <title>BikeAttack</title>
    <style>
        table {
        position: relative;
        top:70%;
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
  <ul id="menu">
  <ul>
        <center>
    <li><a href="AdaugareProduse.php">Adaugare</a></li>
    <li><a href="Editare.php">Editare</a></li>		
    <li><a>Comenzi</a></li>
	<?php
	if($user_data['ID']==0)
	 echo '<li><a href="Login.php">Login</a></li>';
	 else echo '<li><a href="logout.php">Logout</a></li>';
	?>
    </center>
   </ul>
</ul>

  </table>
<form method="POST" >
<div class="wrapper">
      <div class="search-input">
        <a href="" target="_blank" hidden></a>
        <input type="text" name="keyword" placeholder="Cuvinte cheie">
        <div class="autocom-box"> 
          <!-- here list are inserted from javascript -->
        </div>
        <div class="icon"><button type="submit" name="cauta" class="fas fa-search"></button></div>
      </div>
</div>
</form> 

<div class="center">
      <h1> Modificare Status</h1>
  <form action="../Functions/UpdateComanda.php" method="post" enctype="multipart/form-data">
  
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
          <input type="hidden" name="idComanda" value="<?php echo $_SESSION["idComanda"] ?>">
          <input type="submit" name="submit" value="Salveaza">
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
    <script src="../ckeditor/ckeditor.js"></script>
   <script src="../Scripts/suggestions.js"></script> 
   <script src="../Scripts/SearchBoxScript.js"></script> 

  <script type="text/javascript">
  var popupViews = document.querySelectorAll('.popup-view');
  var popupBtns = document.querySelectorAll('.popup-btn');
  var closeBtns = document.querySelectorAll('.close-btn');

  //javascript for quick view button
  var popup = function(popupClick){
    popupViews[popupClick].classList.add('active');
  }

  popupBtns.forEach((popupBtn, i) => {
    popupBtn.addEventListener("click", () => {
      popup(i);
    });
  });
  //javascript for close button
  closeBtns.forEach((closeBtn) => {
    closeBtn.addEventListener("click", () => {
      popupViews.forEach((popupView) => {
        popupView.classList.remove('active');
      });
    });
  });
  </script>
  </body>
</html>
