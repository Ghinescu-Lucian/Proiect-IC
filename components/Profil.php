<?php 
session_start();

	include("../Functions/connection.php");
	include("../Functions/Functions.php");
  include("../Functions/function2.php");
  
    //read from database
    $user_data=check_login($con);
    $orders_data= getOrdersUser($con,$user_data["Username"]);
   
   

//$query = "select * from users where Username = '$Username' limit 1";
// $result = mysqli_query($con, $query);

//while($user_data = $result->fetch_assoc()) {
  $ID=$user_data["ID"];
  $Nume=$user_data["Nume"];
  $Email=$user_data["Email"];
  $img=$user_data["img"];
  $res = getImageProfil($user_data["Username"]);

           
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
    <link rel="stylesheet" href="../styles/Profile.css">
  </head>
  <body>
  <div class="profile">
    <?php 
    echo '<h2 style="text-align:center">User Profile</h2>
    <img src="../uploads/'.$res.'" alt="" style="width: 350px">
    
    <h1>Name:'.$Nume.'</h1>
      
    <p class="email">'.$Email.'</p>
  

    ';
    ?>
    <h1>Comenzi:</h1>
    <table class="orders">
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
        // while($orders_data->fetch_assoc()) {
        //   //  echo 'ID: ' .$row["idProduct"] ;
        //   if
        //   if(empty($row['Status'])) $row['Status']="In procesare";
        // echo '
        // <tr>
        //     <td>'.$orders_data['idOrder'].'</td>
        //     <td>'.$orders_data['Pret'].' lei</td>
        
        //     <td>'.$orders_data['Username'].'</td>
        //     <td>'.$orders_data['Status'].'</td>
        //     <td>  
        //     </td>
        // </tr>
        // ';
        // }
        
    ?>
    </tbody>
    </table>
    <a href="../Index.php">Home</a>
  
    </div>
    
   

  </body>
</html>
