<?php

require_once 'config.php';
$id = $_GET['Id'];
$delete = "DELETE FROM products WHERE Id = $id";
$run_data = mysqli_query($link,$delete);

if($run_data){
	header('location:index.php');
}else{
	echo "FAILED DELETE";
}


?>