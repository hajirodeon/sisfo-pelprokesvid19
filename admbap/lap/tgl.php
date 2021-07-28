<?php
//////////////////////////////////////////////////////////////////////
// SISFO-PELPROKESVID19 v1.0                                        //
// Sistem Informasi untuk pendataan pelanggar Prokes Covid-19       //
// agar bisa diketahui posisi lokasinya, rangking pelanggaran warga //
// sampai dengan rincian pelanggaran yang telah dilakukan           //
// cocok digunakan untuk SatPol PP maupun Satgas Covid-19, yang     //
// sedang melakukan operasi/razia pelanggaran prokes di lapangan.   //    
//////////////////////////////////////////////////////////////////////
// Dikembangkan oleh : Agus Muhajir                                 //
// E-Mail : hajirodeon@gmail.com                                    //
// HP/SMS/WA : 081-829-88-54                                        //
// source code : http://github.com/hajirodeon                       //
//////////////////////////////////////////////////////////////////////




session_start();

//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admbap.php");
$tpl = LoadTpl("../../template/adminbap.html");

nocache;

//nilai
$filenya = "tgl.php";
$judul = "[LAPORAN]. PER TANGGAL";
$judulku = "$judul";
$juduli = $judul;













//isi *START
ob_start();


//jml notif
$qyuk = mysqli_query($koneksi, "SELECT * FROM petugas_history_entri ".
									"WHERE petugas_kode = '$username4_session' ".
									"AND dibaca = 'false'");
$jml_notif = mysqli_num_rows($qyuk);

echo $jml_notif;

//isi
$i_loker = ob_get_contents();
ob_end_clean();

















//isi *START
ob_start();




?>










<!-- jQuery 3 -->
<script src="<?php echo $sumber;?>/template/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $sumber;?>/template/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="<?php echo $sumber;?>/template/adminlte/dist/js/adminlte.min.js"></script>




<!-- Bootstrap core JavaScript -->
<script src="<?php echo $sumber;?>/template/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<!-- Bootstrap core CSS -->
<link href="<?php echo $sumber;?>/template/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet">



<!-- ChartJS -->
<script src="<?php echo $sumber;?>/template/adminlte/bower_components/chart.js/Chart.js"></script>


    
  


<!-- Bootstrap core JavaScript -->
<script src="<?php echo $sumber;?>/template/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo $sumber;?>/template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>





<?php
//PROSES PENGUMPULAN NILAI DULU ///////////////////////////////////////////////////////////////////////
$tahunnya = $tahun;

//hapus dulu yg ada
mysqli_query($koneksi, "DELETE FROM lap_tanggal ".
							"WHERE tahun = '$tahunnya' ".
							"AND bulan = '$bulan'");




for ($k=1;$k<=31;$k++)
	{
	//kasi nol
	if ($k<10)
		{
		$kk = "0$k";
		}
	else
		{
		$kk = $k;
		}
		
		
	
	
		
		
		
	//ambil nilai
	$qyuk = mysqli_query($koneksi, "SELECT kd FROM petugas_entri ".
										"WHERE round(DATE_FORMAT(postdate, '%d')) = '$kk' ".
										"AND round(DATE_FORMAT(postdate, '%m')) = '$bulan' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$tahunnya'");
	$tyuk = mysqli_num_rows($qyuk);
	
	

	
	//insert
	$xyz = "$x$k";
	mysqli_query($koneksi, "INSERT INTO lap_tanggal(kd, tahun, bulan, tanggal, jml, postdate) VALUES ".
								"('$xyz', '$tahunnya', '$bulan', '$k', '$tyuk', '$today')"); 		
	}
//PROSES PENGUMPULAN NILAI DULU ///////////////////////////////////////////////////////////////////////
















//jml semua
$qku2x = mysqli_query($koneksi, "SELECT SUM(jml) AS totalku ".
									"FROM lap_tanggal ".
									"WHERE round(DATE_FORMAT(postdate, '%m')) = '$bulan' ".
									"AND round(DATE_FORMAT(postdate, '%Y')) = '$tahunnya'");
$rku2x = mysqli_fetch_assoc($qku2x);
$tku2x = balikin($rku2x['totalku']);


//jika null
if (empty($tku2x))
	{
	$tku2x2 = 0;
	}
else 
	{
	$tku2x2 = $tku2x;
	}







//tampilkan
$qku = mysqli_query($koneksi, "SELECT * FROM lap_tanggal ". 
								"WHERE round(DATE_FORMAT(postdate, '%m')) = '$bulan' ".
								"AND round(DATE_FORMAT(postdate, '%Y')) = '$tahunnya' ".
								"ORDER by round(tanggal) ASC");
$rku = mysqli_fetch_assoc($qku);
$tku = mysqli_num_rows($qku);


do 
	{
	$i_tahun = balikin($rku['tahun']);
	$i_bulan = balikin($rku['bulan']);
	$i_nama = balikin($rku['tanggal']);
	$i_nama2 = cegah($rku['tanggal']);
	$i_jmlku = balikin($rku['jml']);

	$tku2 = $i_jmlku;

	
	//jika null
	if (empty($tku2))
		{
		$tku2x = 0;
		
		$persennya = 0;
		}
	else
		{		
		$tku2x = $tku2;
		
		$persennya = round(($tku2x / $tku2x2) * 100,2); 
		}




	echo '<div class="progress-group">
		<span class="progress-text">'.$i_nama.' '.$arrbln1[$i_bulan].' '.$i_tahun.'</span>
		<span class="progress-number"><b>'.$tku2x.'</b>/'.$tku2x2.'</span>
	
		<div class="progress sm">
			<div class="progress-bar progress-bar-red" style="width: '.$persennya.'%"></div>
		</div>
	</div>';
	}
while ($rku = mysqli_fetch_assoc($qku));






//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");



//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>