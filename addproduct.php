<?php
require_once "config.php";
if(isset($_POST['submit'])){
	$TenXe = $_POST['TenXe'];
	$Giathanh = $_POST["Giathanh"];
    $HinhAnh = $_FILES['HinhAnh']['name'];
	$msg = "";
	$target = "img/".basename($HinhAnh);
	if (move_uploaded_file($_FILES['HinhAnh']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
  	}
  	$insert_data = "INSERT INTO products (Name,HinhAnh,GiaThanh) VALUES ('$TenXe','$target','$Giathanh')";
    $run_data = mysqli_query($link,$insert_data);

  	if($run_data){
  		header('location:index.php');
  	}else{
  		echo "Thêm xe không thành công";
  	}

}
?>