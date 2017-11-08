<?php
@session_start();
include "inc/koneksi.php";
if(@$_SESSION['username']){
?>

<?php error_reporting(0) // tambahkan untuk menghilangkan notice... hehe ?>
<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
        <title>ATK</title>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <style>
            /*fix margin pagination*/
            .pagination{
                margin-top: 0px;
            }
            #footer{
              text-align: center;
              padding: 20px;
              background-color: #D3D3D3;
              font-size: 13px;
            }
            table,tr,th,td{
                text-align: center;
                font-size: 12px;
            }
            h4{
                color: white;
                background-color: #B8860B;
                padding: 5px;
            }
        </style>
    </head>
    <body>
        <?php 
//        includekan fungsi paginasi
        include 'inc/pagination1.php';
//        koneksi ke database
        include 'inc/koneksi.php';
        
        
//        mengatur variabel reload dan sql
        if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
//        jika ada kata kunci pencarian (artinya form pencarian disubmit dan tidak kosong)
//        pakai ini
            $keyword=$_REQUEST['keyword'];
            $reload = "index.php?pagination=true&keyword=$keyword";
            $sql =  "SELECT * FROM tbl_inventory WHERE item LIKE '%$keyword%' or merk LIKE '%$keyword%'";
            $result = mysqli_query($koneksi,$sql);
        }else{
//            jika tidak ada pencarian pakai ini
            $reload = "index.php?pagination=true";
            $sql =  "SELECT * FROM tbl_inventory";
            $result = mysqli_query($koneksi, $sql);
        }
        
        //pagination config start
        $rpp = 10; // jumlah record per halaman
        $page = intval($_GET["page"]);
        if($page<=0) $page = 1;  
        $tcount = mysqli_num_rows($result);
        $tpages = ($tcount) ? ceil($tcount/$rpp) : 1; // total pages, last page number
        $count = 0;
        $i = ($page-1)*$rpp;
        $no_urut = ($page-1)*$rpp;
        //pagination config end
        ?>
        <div class="container">
        <center><h1>Sistem Informasi Alat Tulis Kantor</h1>
        <h4>Welcome, <?php echo $_SESSION['username'] ?></h4>
        </center><hr>
            <div class="row">

                <div class="col-lg-8">
                    <a href="inc/list_request.php"><button class="btn btn-info btn-sm">List Request</button></a>
                    <!--muncul jika ada pencarian (tombol reset pencarian)-->
                    <?php
                    if($_REQUEST['keyword']<>""){
                    ?>
                        <a class="btn btn-default btn-outline btn-sm" href="index.php"> Reset Pencarian</a>
                    <?php
                    }
                    ?>
                </div>
                <div class="col-lg-4 text-right">
                    <form method="post" action="index.php">
                        <div class="form-group input-group">
                            <input type="text" name="keyword" class="form-control" placeholder="Search..." value="<?php echo $_REQUEST['keyword']; ?>">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Cari
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Id</th>
                        <th>Item</th>
                        <th>Merk</th>
                        <th>Type</th>
                        <th>Warna</th>
                        <th>Ukuran</th>
                        <th>Detail</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while(($count<$rpp) && ($i<$tcount)) {
                        mysqli_data_seek($result,$i);
                        $data = mysqli_fetch_array($result);
                    ?>
                    <tr>
                        <td><?php echo ++$no_urut;?></td>
                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo $data['item']; ?></td>
                        <td><?php echo $data['merk']; ?></td>
                        <td><?php echo $data['type']; ?></td>
                        <td><?php echo $data['warna']; ?></td>
                        <td><?php echo $data['ukuran']; ?></td>
                        <td><?php echo $data['detail']; ?></td>
                        <td><?php echo $data['stok']; ?></td>
                        <td><a href="inc/request.php?id=<?php echo $data['id']; ?>"><button class="btn btn-success btn-sm">Request</button></a></td>
                    </tr>
                    <?php
                        $i++; 
                        $count++;
                    }
                    ?>
                </tbody>
            </table>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <?php echo paginate_one($reload, $page, $tpages); ?>
                </div>
                <div class="col-md-4 text-right">
                    <!--form ini akan brfungsi untuk mengirimkan query sql yang sekarang aktif-->
                    <!--sql diambil dari baris 28 atau 33, tergantung ada atau tidaknya kata kunci pencarian-->
                    <a href="inc/logout.php"><button class="btn btn-danger btn-sm">Logout</button></a>
                </div><br>
            </div>
        </div>

        <div id="footer">
          Copyright &copy; 2017-<?php echo date('Y'); ?>. Created by Dimas Prasetio. All Rights Reserved
        </div>
    </body>
</html>
<?php
}else{
  header("location:inc/login.php");
}
?>

<!--harviacode.com-->