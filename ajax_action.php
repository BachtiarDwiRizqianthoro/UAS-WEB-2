<!-- Validasi data -->
<?php 
	include "config.php";
	$uid=$_POST["uid"];
	$nomor=mysqli_real_escape_string($con,$_POST["nomor"]);
	$merk=mysqli_real_escape_string($con,$_POST["merk"]);
	$tipe=mysqli_real_escape_string($con,$_POST["tipe"]);
	if($uid=="0"){

		//fungsi tambah data
		$sql="insert into user (NOMOR,MERK,TIPE) values ('{$nomor}','{$merk}','{$tipe}')";
		if($con->query($sql)){
			$uid=$con->insert_id;
			echo"<tr class='{$uid}'>
				<td>{$nomor}</td>
				<td>{$merk}</td>
				<td>{$tipe}</td>
				<td><a href='#' class='btn btn-warning edit' uid='{$uid}'>Edit</a></td>
				<td><a href='#' class='btn btn-danger del' uid='{$uid}'>Delete</a></td>					
			</tr>";
			
		}
	}else{

		//fungsi update data
		$sql="update user set NOMOR='{$nomor}',MERK='{$merk}',TIPE='{$tipe}' where UID='{$uid}'";
		if($con->query($sql)){
			echo"
				<td>{$nomor}</td>
				<td>{$merk}</td>
				<td>{$tipe}</td>
				<td><a href='#' class='btn btn-warning edit' uid='{$uid}'>Edit</a></td>
				<td><a href='#' class='btn btn-danger del' uid='{$uid}'>Delete</a></td>					
			";
		}
	}
?>