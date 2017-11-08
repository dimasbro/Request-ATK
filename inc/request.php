<?php
@session_start();
include "../inc/koneksi.php";
date_default_timezone_set('Asia/Jakarta');
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
	<title>Request</title>
</head>
<link rel="stylesheet" href="../css/bootstrap.min.css"/>
<style type="text/css">
body{
	font-family: arial;
}
table,tr,th,td,input{
	padding: 3px;
	text-align: left;
	font-size: 13px;
}
#footer{
    text-align: center;
    padding: 20px;
    background-color: #D3D3D3;
    font-size: 13px;
}
</style>
<?php
$id = @$_GET['id'];
$query = mysqli_query($koneksi, "select * from tbl_inventory where id='$id'") or die (mysqli_error());
$r = mysqli_fetch_array($query);
?>
<body>
<div class="container">
<center>
<form action="" method="post">
<h1>Request Kebutuhan</h1><hr>
<table>
<tr>
	<td></td>
	<td></td>
	<td><input type="hidden" name="id" value="<?php echo $r['id']; ?>" /></td>
</tr>
<tr>
	<td>Item</td>
	<td>:</td>
	<td><input type="text" name="item" value="<?php echo $r['item']; ?>" class="form-control" readonly /></td>
</tr>
<tr>
	<td>Merk</td>
	<td>:</td>
	<td><input type="text" name="merk" value="<?php echo $r['merk']; ?>" class="form-control" readonly /></td>
</tr>
<tr>
	<td>Detail</td>
	<td>:</td>
	<td><input type="text" name="detail" value="<?php echo $r['detail']; ?>" class="form-control" readonly /></td>
</tr>
<tr>
	<td>Stok</td>
	<td>:</td>
	<td><input type="text" name="stok" value="<?php echo $r['stok']; ?>" class="form-control" readonly /><td>
<tr>
<tr>
	<td>Qty Kebutuhan</td>
	<td>:</td><td>
	<select name="qty" class="form-control">
		<?php
		for($i=1; $i<=10; $i++){
			echo '<option value="'.$i.'">'.$i.'</option>';
		}
		?>
	</select>
	<td>
<tr>
<tr><td></td><td></td><td><input type="submit" name="bok" value="Request" class="btn btn-success" /></td></tr>
</table>
</form>
</center></div><br>
<div id="footer">
     Copyright &copy; 2017-<?php echo date('Y'); ?>. Created by Dimas Prasetio. All Rights Reserved
</div>
</body>
</html>
<?php
/*
no_request = 17102017/ENV-NA-08-PA4/DIM/325
request_by = dimas
item = ENV-NA-08-PA4
detail = AMPLOP PUTIH POLOS A4
quantity = 1
request_date = 2017/10/17
status = 'WAITING FOR APPROVAL'
*/
if(isset($_POST['bok'])) {
	$request_by = strtoupper(@$_SESSION['username']);
	$item = $_POST['id'];
	$detail = $_POST['detail'];
	$stok = $_POST['stok'];
	$quantity = @$_POST['qty'];
	$request_date = date("Y/m/d");
	$status = "WAITING FOR APPROVAL";

	$requestr = substr($request_by, 0, 3);

	$no_request = date('Ymd')."/".$item."/".strtoupper($requestr)."/".date('ms');

	if($quantity > $stok){
		?>
		<script type="text/javascript">
		alert("quantity tidak melebihi nilai stok");
		</script>
		<?php
	}else if($no_request=="" || $request_by=="" || $item=="" || $detail=="" || $quantity=="" || $request_date=="" || $status==""){
		?>
		<script type="text/javascript">
		alert("harus diisi semua");
		</script>
		<?php
	}else{
	/*echo "no_request: ".$no_request."<br>";
	echo "nama: ".$request_by."<br>";
	echo "item: ".$item."<br>";
	echo "detail: ".$detail."<br>";
	echo "quantity: ".$quantity."<br>";
	echo "request_date: ".$request_date."<br>";
	echo "status: ".$status."<br>";*/
	$q = "insert into tbl_request(no_request,request_by,item,detail,quantity,request_date,status) values('$no_request','$request_by','$item','$detail','$quantity','$request_date','$status')";
	mysqli_query($koneksi,$q) or die (mysqli_error());
			?>
		    <script language="javascript">
                window.location.href="../index.php";
            </script>
		    <?php
	}
}
?>