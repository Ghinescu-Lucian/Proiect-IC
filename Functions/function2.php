<?php
//include("connection.php");




function getImage($idProduct){
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "bikeattack";
    $con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

	$image_query = mysqli_query($con,"select Nume from productimages where idProduct = '$idProduct' limit 1");
	while($rows = mysqli_fetch_array($image_query))
        {
            //$img_name = $rows['img_name'];
            $img_src = $rows['Nume'];
            return $img_src;
        }
	
    }

    
function getProducts($con){
	$product_query = mysqli_query($con,"select * from product where Cantitate != 0 order by Pret ASC");
	return $product_query;
}
function getProductsKey($con,$keyword){
	$product_query = mysqli_query($con,"select * from product where Nume LIKE '%$keyword%' OR Descriere LIKE '%$keyword%'  ORDER BY Pret");
	return $product_query;
}
function getQuantity($con, $idProduct){
	$result = mysqli_query($con,"select Cantitate from product where idProduct = $idProduct");
    $Quantity = mysqli_fetch_assoc($result);
    return $Quantity;
}



?>
