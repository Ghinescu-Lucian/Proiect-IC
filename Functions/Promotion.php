<?php
// Include the database configuration file
session_start();
include("../Functions/connection.php");
include("../Functions/Functions.php");
include("../Functions/function2.php");
$user_data=check_login($con);;
$statusMsg = '';


if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$Nume = $_POST['Nume'];
		$Cantitate = $_POST['Cantitate'];
    $Pret = $_POST['Pret'];
    $Descriere = trim($_POST['Descriere']);
   // $Name = $_POST['Name'];
  
    
	 if(!empty($Nume) && !empty($Cantitate) && !empty($Pret))
		{

        //save to database
      //	$user_id = random_num(20);
        $query1= "select Denumire from promotii where Denumire='$Nume'";
        $result = mysqli_query($con, $query1);
        $user_data = mysqli_fetch_assoc($result);
					
       // echo $result;
        if($user_data['Denumire'] === $Nume )
        { 
          echo '<script type="text/javascript">
          window.onload = function () { alert("Promotia cu acest nume exista deja!"); }
        </script>';
        }
        else {
          $query = "insert into promotii (Denumire,Descriere,Pret,Cantitate) values ('$Nume','$Descriere','$Pret','$Cantitate')";
           $result = mysqli_query($con, $query);
           echo '<script type="text/javascript">
           window.onload = function () { alert("Produs adaugat cu succes!"); }
         </script>';
        }
        //if($result) echo "good"; 
        //else echo "Bad";
        // echo "<script>window.location = '../components/AdaugarePromotie.php'</script>";
        //die;

      

        $promoId = getLastPromoId($con);
        $val = "";
   
    if (isset($_SESSION['shopping_cart'])){
      //  $product_id = array_column($_SESSION['shopping_cart'], 'idProduct');
          foreach($_SESSION["shopping_cart"] as $keys => $values)
          {
              $val = $val." "."('".$values['item_id']."','".$promoId."','".$values['item_quantity']."' ),";
              // $Detalii = $Detalii." ".$values['item_name']." ".$values['item_price']." x ".$values['item_quantity'];
              // $total = $total + (int)$values['item_price'] * (int)$values['item_quantity'];
            // unset($_SESSION['shopping_cart'][$key]);    
          }
         $val= substr_replace($val,"",-1);
  
      }
    if(!empty($val))
        {
           echo $val;
          // echo $promoId;

            $query2 = "insert into produsepromotionale (idProdus, idPromotie, Cantitate) values ".$val."";

            $result2 = mysqli_query($con, $query2);
            // echo $query2;

            if($result2)
            {
                  foreach ($_SESSION['shopping_cart'] as $key => $value)
                    unset($_SESSION['shopping_cart'][$key]);
                
                  echo "<script>alert('Promotie inregistrata  cu succes!')</script>";
                  if(strcmp($user_data['Username'],"Admin")==0)
                     echo "<script>window.location = '../components/AdaugareProduse.php'</script>";   
                  else   echo "<script>window.location = 'Index.php'</script>"; 
            }
            else{
        echo "<script>alert('Eroare baza de date!')</script>";
        if(strcmp($user_data['Username'],"Admin")==0)
           echo "<script>window.location = '../components/AdaugareProduse.php'</script>";
        else   echo "<script>window.location = 'Index.php'</script>";  

      }
        }else
        {
      echo "<script>alert('Completati toate campurile!')</script>";
    //  echo "<script>window.location = '../components/AdaugarePromotie.php'</script>";
    }

		}else
		{
			echo "Please enter some valid information!";
		}
   
}

// File upload path
$targetDir = "../uploads/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
			$query1 = "select * from promotii order by idPromo DESC limit 1";
			$result1= mysqli_query($con,$query1);
			$user_data = mysqli_fetch_assoc($result1);
      $promoId = $user_data['idPromo'];
    //  $insert = $con->query("INSERT into promotii (Image) VALUES ('".$fileName."') ");
      $insert = $con->query("UPDATE promotii SET Image = '$fileName' WHERE  idPromo = '$promoId' ");
        if($insert){
                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
               // echo "Promotion ID: '".$user_data."' ";
               // header('Location: ../components/AdaugarePromotie.php');
            }else{
                $statusMsg = "File upload failed, please try again.";
            } 
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}else{
    $statusMsg = 'Please select a file to upload.';
}

// Display status message
//echo $statusMsg;
?>