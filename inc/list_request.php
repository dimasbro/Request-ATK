<?php
@session_start();
include "../inc/koneksi.php";
date_default_timezone_set('Asia/Jakarta');
$username = $_SESSION['username'];

$ex = mysqli_query($koneksi,"select * from tbl_request where request_by='$_SESSION[username]' and status='WAITING FOR APPROVAL' order by no_request desc");
?>
<!DOCTYPE html>
<html>
<head>
	<title>List Request</title>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
</head>
<link rel="stylesheet" href="../css/bootstrap.min.css"/>
<style type="text/css">
body{
	font-family: arial;
}
table,tr,th,td{
	padding: 5px;
	border-collapse: collapse;
	text-align: center;
	font-size: 11px;
}
th{
	background-color: blue;
	color: white;
}
#footer{
    text-align: center;
    padding: 20px;
    background-color: #D3D3D3;
    font-size: 13px;
}
</style>
<body>
<div class="container">
<center>
<h2>List Request ATK</h2><hr>
<div class="table-responsive">
            <table class="table table-bordered">
		<tr>
			<th>No</th>
			<th>No Request</th>
			<th>Nama</th>
			<th>Item</th>
			<th>Detail</th>
			<th>Quantity</th>
			<th>Request Date</th>
			<th>Status</th>
		</tr>
<?php
$no=1;
while($r = mysqli_fetch_array($ex)){
if($no%2 != 0){
    $color='white';
}else{
    $color='#CCCCCC';
}
	echo "<tr bgcolor='$color'>";
	echo "<td>".$no."</td>";
	echo "<td>".$r['no_request']."</td>";
	echo "<td>".$r['request_by']."</td>";
    echo "<td>".$r['item']."</td>";
    echo "<td>".$r['detail']."</td>";
    echo "<td>".$r['quantity']."</td>";
    echo "<td>".$r['request_date']."</td>";
    echo "<td>".$r['status']."</td>";
	echo "</tr>";
$no++; 
}
?>
</table>
</div>
<br>
<a href="../index.php"><button class="btn btn-danger">Kembali</button></a>
</center>
</div><br>
<div id="footer">
     Copyright &copy; 2017-<?php echo date('Y'); ?>. Created by Dimas Prasetio. All Rights Reserved</div>
</body>
</style>




		