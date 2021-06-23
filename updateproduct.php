<?php
require_once "config.php";
$id=$_GET['Id'];
if(isset($_POST['submit'])){
    $Tenxe=$_POST['Name'];
    $Giathanh=$_POST['Giathanh'];
    $Hinhanh=$_FILES['HinhAnh']['name'];
    if(empty($Hinhanh)){
        $update="UPDATE products SET Name='$Tenxe',GiaThanh='$Giathanh' WHERE Id = $id";
        $run_update=mysqli_query($link,$update);
        if($run_update){
            header("location:index.php");
        }else{
            echo "Failed update";
        }
    }else{
        $target = "img/".basename($Hinhanh);
        if (move_uploaded_file($_FILES['HinhAnh']['tmp_name'], $target)) {
            echo "Image uploaded successfully";
        }else{
            echo "Failed to upload image";
        }
        $update="UPDATE products SET Name='$Tenxe',GiaThanh='$Giathanh',HinhAnh='$target' WHERE Id = $id";
        $run_update=mysqli_query($link,$update);
        if($run_update){
			header('location:index.php');
		}else{
			echo "Failed update";
		}
    }
} 
?>