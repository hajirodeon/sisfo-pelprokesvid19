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
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
require("../inc/cek/admpetugas.php");




//jika pmasuk
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'pmasuk'))
	{
	//nilai
	$latx = cegah($_GET['latx']);
	$laty = cegah($_GET['laty']);


	$latx2 = balikin($_GET['latx']);
	$laty2 = balikin($_GET['laty']);
	
	
	//echo "$latx2, $laty2 -> ";

		
	//update
	mysqli_query($koneksi, "UPDATE m_petugas SET lat_x = '$latx2', ".
								"lat_y = '$laty2', ".
								"postdate_tugas = '$today' ".
								"WHERE tipe_user = 'PETUGAS' ".
								"AND kode = '$username3_session'");


	
	
	
		
	//jadikan alamat //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$qyuk = mysqli_query($koneksi, "SELECT * FROM m_petugas ".
										"WHERE tipe_user = 'PETUGAS' ".
										"AND kode = '$username3_session'");
	$ryuk = mysqli_fetch_assoc($qyuk);
	$kdku = balikin($ryuk['kd']);
	$lat = balikin($ryuk['lat_x']);
	$long = balikin($ryuk['lat_y']);
	
	
	//echo "[$lat]. [$long]";
	
	
	
	//akun cakmustofa
	$keyku = "AIzaSyBZ73oHLqNFmGX6bs3qyyRAoCim-_WxdqQ";
	
	
	function geo2address($lat,$long,$keyku) {
		
	    $url = "https://maps.googleapis.com/maps/api/geocode/json?key=$keyku&latlng=$lat,$long&sensor=false";
	    $curlData=file_get_contents(    $url);
	    $address = json_decode($curlData);
	    $a=$address->results[0];
	    return explode(",",$a->formatted_address);
	}
	
	
	
	
	$nilku = geo2address($lat,$long,$keyku);
	
	
	$nil1 = $nilku[0];
	$nil2 = $nilku[1];
	$nil3 = $nilku[2];
	$nil4 = $nilku[3];
	$nil5 = $nilku[4];
	$nil6 = $nilku[5];
	$nil7 = $nilku[6];
	
	
	$nilaiku = cegah("$nil1, $nil2, $nil3, $nil4, $nil5, $nil6, $nil7");
	$nilaiku2 = balikin($nilaiku);
	//echo $nilaiku2;

	 	
	//update
	mysqli_query($koneksi, "UPDATE m_petugas SET alamat_googlemap = '$nilaiku' ".
								"WHERE tipe_user = 'PETUGAS' ".
								"AND kode = '$username3_session'");
	
	
	
	
	
	
	
	
	//pecah cari kecamatan /////////////////////////////////////////////////////////////////////////
	//pecah kecamatan	
	$pecahku = explode("Kec.", $nilaiku2);
	$nil1 = trim($pecahku[1]);
	
	$pecahku2 = explode(",", $nil1);
	$nil2 = trim($pecahku2[0]);
	
	$kecnya = $nil2;
	

	//update
	mysqli_query($koneksi, "UPDATE m_petugas SET kecamatan = '$kecnya', ".
								"alamat_googlemap = '$nilaiku' ".
								"WHERE tipe_user = 'PETUGAS' ".
								"AND kode = '$username3_session'");
								
								
								
										
	
	//detail
	$qku = mysqli_query($koneksi, "SELECT * FROM m_petugas ".
							"WHERE tipe_user = 'PETUGAS' ".
							"AND kode = '$username3_session'");
	$rku = mysqli_fetch_assoc($qku);
	$ku_kd = balikin($rku['kd']);
	$ku_kode = balikin($rku['kode']);
	$ku_nama = balikin($rku['nama']);
	$ku_alamat = balikin($rku['alamat_googlemap']);
	$ku_kec = balikin($rku['kecamatan']);
	$ku_latx = balikin($rku['lat_x']);
	$ku_laty = balikin($rku['lat_y']);
	$ku_postdate_tugas = balikin($rku['postdate_tugas']);
									
									
									
		
	//insert
	mysqli_query($koneksi, "INSERT INTO petugas_history_gps(kd, petugas_kd, petugas_kode, ".
					"petugas_nama, petugas_tipe, ".
					"lat_x, lat_y, alamat_googlemap, kecamatan, postdate) VALUES ".
					"('$x', '$ku_kd', '$ku_kode', ".
					"'$ku_nama', 'PETUGAS', ".
					"'$ku_latx', '$ku_laty', '$ku_alamat', '$ku_kec', '$today')");
	
	}
	
	
	

//jika error
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'error'))
	{
	//echo "GPS Tidak Aktif";
	?>
		
		<div class="row">
		
		  <div class="col-lg-12">
		    <div class="info-box mb-3 bg-danger">
		      <span class="info-box-icon"><i class="fa fa-user-secret"></i></span>
		
		      <div class="info-box-content">
		        <span class="info-box-number">
		        		<b>GPS TIDAK AKTIF</b>
					</span>
		      </div>
		    </div>
		
			</div>
			
		</div>


	
	
	  <!-- Content Wrapper. Contains page content -->
	  <div class="content-wrapper">
	
	    <!-- Main content -->
	    <section class="content">
	      <div class="container-fluid">

			<h3>Silahkan Aktifkan GPS Terlebih Dahulu.</h3>
			<i>Kemudian Refresh Browser</i>				
	
	      </div>
	    </section>
	    <!-- /.content -->

	    
	    
	    
	  </div>
	  <!-- /.content-wrapper -->
	

		

	<?php	
	}





//kasi log login ///////////////////////////////////////////////////////////////////////////////////
$todayx = $today;
	


	//ketahui ip
function get_client_ip_env() {
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if(getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if(getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if(getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if(getenv('HTTP_FORWARDED'))
		$ipaddress = getenv('HTTP_FORWARDED');
	else if(getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = 'UNKNOWN';
	
		return $ipaddress;
	}


$ipku = get_client_ip_env();


					


													

//detail
$qku = mysqli_query($koneksi, "SELECT * FROM m_petugas ".
						"WHERE tipe_user = 'PETUGAS' ".
						"AND kode = '$username3_session'");
$rku = mysqli_fetch_assoc($qku);
$ku_kd = cegah($rku['kd']);
$ku_kode = cegah($rku['kode']);
$ku_nama = cegah($rku['nama']);

	


//insert
mysqli_query($koneksi, "INSERT INTO petugas_login(kd, petugas_kd, petugas_kode, petugas_nama, ".
				"petugas_tipe, ipnya, postdate) VALUES ".
				"('$x', '$ku_kd', '$ku_kode', '$ku_nama', ".
				"'PETUGAS', '$ipku', '$today')");
//kasi log login ///////////////////////////////////////////////////////////////////////////////////

exit();
?>