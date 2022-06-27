<?php
	include "config.php";
?>
<html>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="#">Showroom Mobil</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
            </div>
        </nav>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	</head>
		
		<!-- JUDUL APLIKASI -->
        <div class="container">
        <div class="card">
        <h5 class="card-header">Showroom Mobil</h5>

		<!-- MEMBUAT FORM TABEL INPUT DATA -->
		<div class='row'>
			<div class="col-md-5">
				<form id='frm'>
				  <div class="form-group">
					<label>Nomer Seri</label>
					<input type="nomor" class="form-control" name="nomor" id='nomor' required placeholder="Nomer Seri">
				  </div>
				  <div class="form-group">
					<label>Merk</label>
					<input type="merk" class="form-control" name="merk" id='merk' required placeholder="Merk">
				  </div>
				  <div class="form-group">
					<label>Tipe</label>
					<input type="tipe" class="form-control"  name="tipe" id='tipe' required placeholder="Tipe">
				  </div>
				  
				  <input type="hidden" class="form-control" name="uid" id='uid' required value='0' placeholder="">
				  
				  <button type="submit" name="submit" id="but" class="btn btn-primary">Submit</button>
				  <button type="button" id="clear" class="btn btn-danger">Reset</button>
				</form> 
			</div>

			<!-- MEMBUAT TABEL DATA -->
			<div class="col-md-7">
				<table class="table table-bordered" id='table'>
					<thead>
						<tr>
							<th>Nomer Seri</th>
							<th>Merk</th>
							<th>Tipe</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>

					<!-- VALIDASI DATA TABEL DENGAN TABEL DI DB  -->
					<tbody>
						<?php
							$sql="select * from user";
							$res=$con->query($sql);
							if($res->num_rows>0)
							{
								while($row=$res->fetch_assoc())
								{	
									echo"<tr class='{$row["UID"]}'>
										<td>{$row["NOMOR"]}</td>
										<td>{$row["MERK"]}</td>
										<td>{$row["TIPE"]}</td>
										<td><a href='#' class='btn btn-warning edit' uid='{$row["UID"]}'>Edit</a></td>
										<td><a href='#' class='btn btn-danger del' uid='{$row["UID"]}'>Delete</a></td>					
									</tr>";
								}
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>	
	<script>
		$(document).ready(function(){
			
			//RESET INPUTAN DATA PADA MENU EDIT
			$("#clear").click(function(){
				$("#nomor").val("");
				$("#merk").val("");
				$("#tipe").val("");
				$("#uid").val("0");
				$("#but").text("Add User");
			});
			
			//MENGUPDATE DATA 
			$("#but").click(function(e){
				e.preventDefault();
				var btn=$(this);
				var uid=$("#uid").val();
				
				
				var required=true;
				$("#frm").find("[required]").each(function(){
					if($(this).val()==""){
						alert($(this).attr("placeholder"));
						$(this).focus();
						required=false;
						return false;
					}
				});
				if(required){
					$.ajax({
						type:'POST',
						url:'ajax_action.php',
						data:$("#frm").serialize(),
						beforeSend:function(){
							$(btn).text("Wait...");
						},
						success:function(res){
							
							var uid=$("#uid").val();
							if(uid=="0"){
								$("#table").find("tbody").append(res);
							}else{
								$("#table").find("."+uid).html(res);
							}
							
							$("#clear").click();
							$("#but").text("Update");
						}
					});
				}
			});
			
			//MENGHAPUS DATA
			$("body").on("click",".del",function(e){
				e.preventDefault();
				var uid=$(this).attr("uid");
				var btn=$(this);
				if(confirm("Are You Sure ? ")){
					$.ajax({
						type:'POST',
						url:'ajax_delete.php',
						data:{id:uid},
						beforeSend:function(){
							$(btn).text("Deleting...");
						},
						success:function(res){
							if(res){
								btn.closest("tr").remove();
							}
						}
					});
				}
			});
			
			//mengisi form input data ssesuai tabel db
			$("body").on("click",".edit",function(e){
				e.preventDefault();
				var uid=$(this).attr("uid");
				$("#uid").val(uid);
				var row=$(this);
				var nomor=row.closest("tr").find("td:eq(0)").text();
				$("#nomor").val(nomor);
				var merk=row.closest("tr").find("td:eq(1)").text();
				$("#merk").val(merk);
				var tipe=row.closest("tr").find("td:eq(2)").text();
				$("#tipe").val(tipe);
				$("#but").text("Update User");
			});
		});
	</script>
	</body>
</html>