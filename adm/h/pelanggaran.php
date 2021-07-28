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

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adm.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/admin.html");

nocache;

//nilai
$filenya = "pelanggaran.php";
$judul = "History Pelanggaran";
$judul = "[HISTORY]. History Pelanggaran";
$judulku = "$judul";
$judulx = $judul;
$kd = nosql($_REQUEST['kd']);
$s = nosql($_REQUEST['s']);
$kunci = cegah($_REQUEST['kunci']);
$kunci2 = balikin($_REQUEST['kunci']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}





//jika cari
if ($_POST['btnCARI'])
	{
	//nilai
	$kunci = cegah($_POST['kunci']);


	//re-direct
	$ke = "$filenya?kunci=$kunci";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//isi *START
ob_start();



//jml notif
$qyuk = mysqli_query($koneksi, "SELECT * FROM petugas_history_entri ".
									"WHERE dibaca = 'false'");
$jml_notif = mysqli_num_rows($qyuk);

echo $jml_notif;

//isi
$i_loker = ob_get_contents();
ob_end_clean();








//isi *START
ob_start();


//require
require("../../template/js/jumpmenu.js");
require("../../template/js/checkall.js");
require("../../template/js/swap.js");
?>


  
  <script>
  	$(document).ready(function() {
    $('#table-responsive').dataTable( {
        "scrollX": true
    } );
} );
  </script>
  

<div class="row">
  <div class="col-lg-12">
  	
	<?php
	//isi *START
	ob_start();
	
	//ketahui ordernya...
	$qyuk = mysqli_query($koneksi, "SELECT DISTINCT(warga_kd) AS wkd ".
							"FROM petugas_entri ".
							"WHERE lat_x <> '' ". 
							"AND alamat_googlemap <> '' ". 
							"ORDER BY postdate DESC LIMIT 0,1000");
	$ryuk = mysqli_fetch_assoc($qyuk);
	
	
	do
		{
		//nilai
		$yuk_wkd = balikin($ryuk['wkd']);
		
		
		//detail 
		$qjoy = mysqli_query($koneksi, "SELECT * FROM petugas_entri ".
											"WHERE warga_kd = '$yuk_wkd' ".
											"ORDER BY postdate DESC");
		$rjoy = mysqli_fetch_assoc($qjoy);
		$tjoy = mysqli_num_rows($qjoy);
		
		//jika ada
		if (!empty($tjoy))
			{
			$yuk_kode = balikin($rjoy['warga_nik']);
			$yuk_nama = balikin($rjoy['warga_nama']);
			$yuk_latx = balikin($rjoy['lat_x']);
			$yuk_laty = balikin($rjoy['lat_y']);
				
			
			echo "['$yuk_kode, $yuk_nama', $yuk_latx,$yuk_laty],";
			}
		}
	while ($ryuk = mysqli_fetch_assoc($qyuk));
	
	
	
	//isi
	$isi_gps22 = ob_get_contents();
	ob_end_clean();
	
	
	
	
	
	
	
	
	
	
	
	
	//isi *START
	ob_start();
	
	
	//ketahui ordernya...
	$qyuk = mysqli_query($koneksi, "SELECT DISTINCT(warga_kd) AS wkd ".
							"FROM petugas_entri ".
							"WHERE lat_x <> '' ". 
							"AND alamat_googlemap <> '' ". 
							"ORDER BY postdate DESC LIMIT 0,1000");
	$ryuk = mysqli_fetch_assoc($qyuk);
	
	
	do
		{
		//nilai
		$yuk_wkd = balikin($ryuk['wkd']);
		
		
		//detail 
		$qjoy = mysqli_query($koneksi, "SELECT * FROM petugas_entri ".
											"WHERE warga_kd = '$yuk_wkd' ".
											"ORDER BY postdate DESC");
		$rjoy = mysqli_fetch_assoc($qjoy);
		$tjoy = mysqli_num_rows($qjoy);
		
		//jika ada
		if (!empty($tjoy))
			{
			$yuk_kode = balikin($rjoy['warga_nik']);
			$yuk_nama = balikin($rjoy['warga_nama']);
			$yuk_lahir_tgl = balikin($rjoy['warga_lahir_tgl']);
			$yuk_telp = balikin($rjoy['warga_telp']);
			$yuk_latx = balikin($rjoy['lat_x']);
			$yuk_laty = balikin($rjoy['lat_y']);
			$yuk_postdate = balikin($rjoy['postdate']);
			
			echo "['<div class=\"info_content\">' +
		        '<h3>$yuk_nama</h3>' +
		        '<p>NIK.$yuk_kode</p>' +
		        '<p>Tanggal Lahir : <b>$yuk_lahir_tgl</b></p>' +
		        '<p>Telp. : <b>$yuk_telp</b></p>' +
		        '<p>Postdate Kejadian : <b>$yuk_postdate</b></p>' +
		        '</div>'],";
			}	
		}
	while ($ryuk = mysqli_fetch_assoc($qyuk));
	
	
	
	//isi
	$isi_gps32 = ob_get_contents();
	ob_end_clean();
		
	
		?>
		
		<style>
			#map_wrapper2 {
		    height: 400px;
		}
		
		#map_canvas2 {
		    width: 100%;
		    height: 100%;
		}
		</style>
		
		
		<h3>POSISI PETA PELANGGAR SAAT INI</h3>
		<div id="map_wrapper2">
		    <div id="map_canvas2" class="mapping"></div>
		</div>
		
		
		
		
		<script>
			jQuery(function($) {
		    // Asynchronously Load the map API 
		    var script = document.createElement('script');
		    script.src = "//maps.googleapis.com/maps/api/js?key=<?php echo $keyku;?>&sensor=false&callback=initialize2";
		    document.body.appendChild(script);
		});
		
		function initialize2() {
		    var map;
		    var bounds = new google.maps.LatLngBounds();
		    var mapOptions = {
		        mapTypeId: 'roadmap'
		    };
		                    
		    // Display a map on the page
		    map = new google.maps.Map(document.getElementById("map_canvas2"), mapOptions);
		    map.setTilt(45);
		        
		    // Multiple Markers
		    var markers = [<?php echo $isi_gps22;?>];
		                        
		    // Info Window Content
		    var infoWindowContent = [<?php echo $isi_gps32;?>
		    ];
		        
		    // Display multiple markers on a map
		    var infoWindow = new google.maps.InfoWindow(), marker, i;
		    
		    // Loop through our array of markers & place each one on the map  
		    for( i = 0; i < markers.length; i++ ) {
		        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
		        bounds.extend(position);
		        marker = new google.maps.Marker({
		            position: position,
		            map: map,
		            title: markers[i][0]
		        });
		        
		        // Allow each marker to have an info window    
		        google.maps.event.addListener(marker, 'click', (function(marker, i) {
		            return function() {
		                infoWindow.setContent(infoWindowContent[i][0]);
		                infoWindow.open(map, marker);
		            }
		        })(marker, i));
		
		        // Automatically center the map fitting all markers on the screen
		        map.fitBounds(bounds);
		    }
		
		    // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
		    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
		        this.setZoom(14);
		        google.maps.event.removeListener(boundsListener);
		    });
		    
		}
		</script>
		     
		
		<br>     
		     
	


  </div>
</div>



<hr>



<?php
//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika null
if (empty($kunci))
	{
	$sqlcount = "SELECT * FROM petugas_entri ".
					"ORDER BY postdate DESC";
	}
	
else
	{
	$sqlcount = "SELECT * FROM petugas_entri ".
					"WHERE alamat_googlemap LIKE '%$kunci%' ".
					"OR petugas_kode LIKE '%$kunci%' ".
					"OR petugas_nama LIKE '%$kunci%' ".
					"OR lat_x LIKE '%$kunci%' ".
					"OR lat_y LIKE '%$kunci%' ".
					"OR warga_nik LIKE '%$kunci%' ".
					"OR warga_nama LIKE '%$kunci%' ".
					"OR warga_lahir_tgl LIKE '%$kunci%' ".
					"OR warga_telp LIKE '%$kunci%' ".
					"OR hukuman_melanggar LIKE '%$kunci%' ".
					"OR hukuman_hukuman LIKE '%$kunci%' ".
					"OR hukuman_selesai_postdate LIKE '%$kunci%' ".
					"ORDER BY postdate DESC";
	}
	
	

//query
$limit = 10;
$p = new Pager();
$start = $p->findStart($limit);

$sqlresult = $sqlcount;

$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysqli_fetch_array($result);



echo '<form action="'.$filenya.'" method="post" name="formx">
<p>
<input name="kunci" type="text" value="'.$kunci2.'" size="20" class="btn btn-warning" placeholder="Kata Kunci...">
<input name="btnCARI" type="submit" value="CARI" class="btn btn-danger">
<input name="btnBTL" type="submit" value="RESET" class="btn btn-info">
</p>
	

<div class="table-responsive">          
<table class="table" border="1">
<thead>

<tr valign="top" bgcolor="'.$warnaheader.'">
<td><strong><font color="'.$warnatext.'">POSTDATE</font></strong></td>
<td width="150"><strong><font color="'.$warnatext.'">FOTO</font></strong></td>
<td><strong><font color="'.$warnatext.'">WARGA</font></strong></td>
<td><strong><font color="'.$warnatext.'">ALAMAT GOOGLEMAP</font></strong></td>
<td><strong><font color="'.$warnatext.'">PETUGAS</font></strong></td>
<td><strong><font color="'.$warnatext.'">BAP.NOMOR</font></strong></td>
<td><strong><font color="'.$warnatext.'">BAP.FOTO</font></strong></td>
<td><strong><font color="'.$warnatext.'">BAP.HUKUMAN</font></strong></td>
<td><strong><font color="'.$warnatext.'">BAP.POSTDATE</font></strong></td>
</tr>
</thead>
<tbody>';

if ($count != 0)
	{
	do 
		{
		if ($warna_set ==0)
			{
			$warna = $warna01;
			$warna_set = 1;
			}
		else
			{
			$warna = $warna02;
			$warna_set = 0;
			}

		$nomer = $nomer + 1;
		$i_kd = nosql($data['kd']);
		$i_postdate = balikin($data['postdate']);
		$i_wkd = balikin($data['warga_kd']);
		$i_wnik = balikin($data['warga_nik']);
		$i_wnama = balikin($data['warga_nama']);
		$i_wtgl = balikin($data['warga_lahir_tgl']);
		$i_wtelp = balikin($data['warga_telp']);
		$i_alamat = balikin($data['alamat_googlemap']);
		$i_petugas = balikin($data['petugas_nama']);
		$i_kode = balikin($data['petugas_kode']);
		$i_bap_nomor = balikin($data['bap_nomor']);
		$i_h_melanggar = balikin($data['hukuman_melanggar']);
		$i_h_jenis = balikin($data['hukuman_jenis']);
		$i_h_hukuman = balikin($data['hukuman_hukuman']);
		$i_h_postdate = balikin($data['hukuman_selesai_postdate']);
		$i_latx = balikin($data['lat_x']);
		$i_laty = balikin($data['lat_y']);
		
		
		$i_foto1 = "../../filebox/warga/$i_wkd/$i_kd/$i_kd-1.jpg";
		$i_foto2 = "../../filebox/warga/$i_wkd/$i_kd/$i_kd-2.jpg";
		$i_foto3 = "../../filebox/warga/$i_wkd/$i_kd/$i_kd-3.jpg";
		$i_foto4 = "../../filebox/warga/$i_wkd/$i_kd/$i_kd-4.jpg";
		
		
		//detail jenis
		$qkuy = mysqli_query($koneksi, "SELECT * FROM m_jenis ". 
											"WHERE kode = '$i_h_jenis'");
		$rkuy = mysqli_fetch_assoc($qkuy);
		$kuy_ket = balikin($rkuy['ket']);	

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$i_postdate.'</td>
		<td>
		<a href="'.$i_foto1.'" target="_blank"><img src="'.$i_foto1.'" width="150"></a>
		<br>
		<br>
		
		<a href="'.$i_foto2.'" target="_blank"><img src="'.$i_foto2.'" width="150"></a>
		<br>
		<br>
		
		<a href="'.$i_foto3.'" target="_blank"><img src="'.$i_foto3.'" width="150"></a>
		<br>
		</td>
		<td>
		NIK.'.$i_wnik.'
		<br>
		'.$i_wnama.'
		<br>
		'.$i_wtgl.'
		<br>
		'.$i_wtelp.'
		</td>
		<td>
		'.$i_alamat.'
		<br>
		'.$i_latx.', '.$i_laty.'
		</td>
		<td>
		'.$i_petugas.'
		<br>
		'.$i_kode.'
		</td>
		<td>'.$i_bap_nomor.'</td>
		<td>
		<a href="'.$i_foto4.'" target="_blank"><img src="'.$i_foto4.'" width="150"></a>
		</td>
		<td>
		<b>'.$i_h_melanggar.'</b>.
		<br> 
		'.$kuy_ket.' '.$i_h_hukuman.'
		</td>
		<td>'.$i_h_postdate.'</td>
        </tr>';
		}
	while ($data = mysqli_fetch_assoc($result));
	}


echo '</tbody>
  </table>
  </div>


<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
<strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'
<br>

<input name="jml" type="hidden" value="'.$count.'">
<input name="s" type="hidden" value="'.$s.'">
<input name="kd" type="hidden" value="'.$kdx.'">
<input name="page" type="hidden" value="'.$page.'">
</td>
</tr>
</table>
</form>';



//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>