<?php
include 'connection.php';
$statusMsg = '';

if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
        $idProduct = $_POST['idProduct'];

                $query = "DELETE FROM product WHERE idProduct = '$idProduct'";
                 $query1 ="SELECT Nume from productimages WHERE idProduct = '$idProduct'";
                 $query2 ="DELETE FROM productimages WHERE idProduct = '$idProduct'";
                 $res=mysqli_query($con,$query1);
                 $res=mysqli_fetch_assoc($res);
                 $path =$res['Nume'];
                if(mysqli_query($con, $query)){
                    unlink('./uploads/'.$path.'');
                    mysqli_query($con,$query2);
                    echo '<script type="text/javascript">
                    window.onload = function () { alert("Produs sters cu succes!"); }
                    </script>';
                   
                }
                else {
                     echo "Bad";
                     echo $idProduct;
                }
                header("Location: ../components/Editare.php");
}
?>