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
require("../../inc/cek/admpetugas.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/adminpetugas.html");

nocache;

//nilai
$filenya = "pelanggaran.php";
$judul = "[LAPORAN]. PER PELANGGARAN";
$judulku = "$judul";
$juduli = $judul;
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
									"WHERE petugas_kode = '$username3_session' ".
									"AND dibaca = 'false'");
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
  
<?php
//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika null
if (empty($kunci))
	{
	$sqlcount = "SELECT * FROM petugas_entri ".
					"WHERE petugas_kode <> '' ".
					"ORDER BY postdate DESC";
	}
	
else
	{
	$sqlcount = "SELECT * FROM petugas_entri ".
					"WHERE petugas_kode <> '' ".
					"AND (postdate LIKE '%$kunci%' ".
					"OR kecamatan LIKE '%$kunci%' ".
					"OR alamat_googlemap LIKE '%$kunci%' ".
					"OR lat_x LIKE '%$kunci%' ".
					"OR lat_y LIKE '%$kunci%' ".
					"OR warga_nik LIKE '%$kunci%' ".
					"OR warga_nama LIKE '%$kunci%' ".
					"OR warga_lahir_tgl LIKE '%$kunci%' ".
					"OR warga_telp LIKE '%$kunci%' ".
					"OR bap_nomor LIKE '%$kunci%' ".
					"OR hukuman_melanggar LIKE '%$kunci%' ".
					"OR hukuman_hukuman LIKE '%$kunci%' ".
					"OR hukuman_selesai_postdate LIKE '%$kunci%') ".
					"ORDER BY postdate DESC";
	}


//query
$limit = 5;
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
<td><strong><font color="'.$warnatext.'">FOTO</font></strong></td>
<td><strong><font color="'.$warnatext.'">NIK</font></strong></td>
<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
<td><strong><font color="'.$warnatext.'">TGL_LAHIR</font></strong></td>
<td><strong><font color="'.$warnatext.'">TELP</font></strong></td>
<td><strong><font color="'.$warnatext.'">KECAMATAN</font></strong></td>
<td><strong><font color="'.$warnatext.'">ALAMAT_GOOGLEMAP</font></strong></td>
<td><strong><font color="'.$warnatext.'">LAT</font></strong></td>
<td><strong><font color="'.$warnatext.'">LONG</font></strong></td>
<td><strong><font color="'.$warnatext.'">BAP.NOMOR</font></strong></td>
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
		$e_kd = nosql($data['kd']);
		$e_postdate = balikin($data['postdate']);
		$e_wkd = balikin($data['warga_kd']);
		$e_wnik = balikin($data['warga_nik']);
		$e_wnama = balikin($data['warga_nama']);
		$e_wtgl = balikin($data['warga_lahir_tgl']);
		$e_wtelp = balikin($data['warga_telp']);
		$e_bap = balikin($data['bap_nomor']);
		$e_h_melanggar = balikin($data['hukuman_melanggar']);
		$e_h_jenis = balikin($data['hukuman_jenis']);
		$e_h_hukuman = balikin($data['hukuman_hukuman']);
		$e_h_postdate = balikin($data['hukuman_selesai_postdate']);
	
					
		//detail jenis
		$qkuy = mysqli_query($koneksi, "SELECT * FROM m_jenis ". 
											"WHERE kode = '$e_h_jenis'");
		$rkuy = mysqli_fetch_assoc($qkuy);
		$kuy_ket = balikin($rkuy['ket']);	
		
		
				
		$e_alamat = balikin($data['alamat_googlemap']);
		$e_latx = balikin($data['lat_x']);
		$e_laty = balikin($data['lat_y']);
		$e_kec = balikin($data['kecamatan']);
	
	
	
		//ketahui foto terakhir
		$imgku1 = "$sumber/filebox/warga/$e_wkd/$e_kd/$e_kd-1.jpg";
		$imgku2 = "$sumber/filebox/warga/$e_wkd/$e_kd/$e_kd-2.jpg";
		$imgku3 = "$sumber/filebox/warga/$e_wkd/$e_kd/$e_kd-3.jpg";
		$imgku4 = "$sumber/filebox/warga/$e_wkd/$e_kd/$e_kd-4.jpg";
	


		
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$e_postdate.'</td>
		<td>
		<a href="'.$imgku1.'" target="_blank"><img src="'.$imgku1.'" width="200"></a>
		<br>
		<br>
		
		<a href="'.$imgku2.'" target="_blank"><img src="'.$imgku2.'" width="200"></a>
		<br>
		<br>
		
		<a href="'.$imgku3.'" target="_blank"><img src="'.$imgku3.'" width="200"></a>
		<br>
		<br>
		</td>
		
		<td>'.$e_wnik.'</td>
		<td>'.$e_wnama.'</td>
		<td>'.$e_wtgl.'</td>
		<td>'.$e_wtelp.'</td>
		<td>'.$e_kec.'</td>
		<td>'.$e_alamat.'</td>
		<td>'.$e_latx.'</td>
		<td>'.$e_laty.'</td>
		<td>
		'.$e_bap.' <br> <a href="'.$imgku4.'" target="_blank"><img src="'.$imgku4.'" width="200""></a>
		</td> 
		<td>
		'.$e_h_melanggar.' <br>'.$kuy_ket.' '.$e_h_hukuman.'
		</td> 
		<td>
		'.$e_h_postdate.'
		</td>
        </tr>';
		}
	while ($data = mysqli_fetch_assoc($result));
	}


echo '</tbody>
  </table>
  </div>


<table width="500" border="0" cellspacing="0" cellpadding="3">
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



//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>