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

nocache;

//nilai
$filenya = "$sumber/admpetugas/d/i_entri1.php";
$filenyax = "$sumber/admpetugas/d/i_entri1.php";
$judul = "ENTRI";
$juduli = $judul;



//nilai session
$wargakd = cegah($_SESSION['wargakd']);
$pelkd = cegah($_SESSION['pelkd']);
$sesiku = cegah($_SESSION['username3_session']);



//detail
$qkuy = mysqli_query($koneksi, "SELECT * FROM m_petugas ".
						"WHERE tipe_user = 'PETUGAS' ".
						"AND kode = '$sesiku'");
$rkuy = mysqli_fetch_assoc($qkuy);
$kuy_kd = cegah($rkuy['kd']);
$kuy_kode = cegah($rkuy['kode']);
$kuy_nama = cegah($rkuy['nama']);
$kuy_tipe = cegah($rkuy['tipe_user']);
$kuy_alamat = cegah($rkuy['alamat_googlemap']);





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika form
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'form'))
	{
	//nilai
	$wargakd = cegah($_SESSION['wargakd']);
	$pelkd = cegah($_SESSION['pelkd']);
	
	//detail
	$qcc = mysqli_query($koneksi, "SELECT * FROM m_warga ".
										"WHERE kd = '$wargakd'");
	$rcc = mysqli_fetch_assoc($qcc);
	$tcc = mysqli_num_rows($qcc);
	$cc_nik = balikin($rcc['nik']);
	$cc_nama = balikin($rcc['nama']);
	$cc_lahir_tgl = balikin($rcc['lahir_tgl']);
	$cc_telp = balikin($rcc['telp']);
	$cc_jml_entri = balikin($rcc['jml_entri']);
	
	?>


	
	<br>


	<table width="100%" border="0" cellpadding="5" cellspacing="5">
	<tr align="top">

	<td width="10">&nbsp;</td>
	<td valign="top">
			
	<div class="row">

		<div class="col-12" align="left">
			<div class="box box-danger">
			<div class="box-body">
			<div class="row">
				<div class="col-md-12">

					<?php
					echo '<p>
					NIK : 
					<br>
					<b>'.$cc_nik.'</b>
					</p>
					
					<p>
					Nama :
					<br>
					<b>'.$cc_nama.'</b>
					</p>
					
					<p>
					Tanggal Lahir :
					<br>
					<b>'.$cc_lahir_tgl.'</b>
					</p>
					
					<p>
					Telepon/HP/WA :
					<br>
					<b>'.$cc_telp.'</b>
					</p>
					
					
					<hr>
					<p>
					Total Melanggar :
					<br>
					<b>'.$cc_jml_entri.'</b> kali.
					</p>';
					?>
					
					
	    	    </div>
				</div>
				</div>
				</div>						

			
		</div>
	
	</div>
				


	</td>

	<td width="10">&nbsp;</td>
	</tr>
	</table>

	<?php
	
	exit();
	}





//lihat gambar
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'lihat'))
	{
	$e_filex1 = "../../filebox/warga/$wargakd/$pelkd/$pelkd-1.jpg";
	
	
	//nek null foto
	if (!file_exists($e_filex1))
		{
		$nil_foto = "$sumber/template/img/bg-black.png";
		}
	else
		{
		$nil_foto = "$sumber/filebox/warga/$wargakd/$pelkd/$pelkd-1.jpg";
		}
		

	echo '<img src="'.$nil_foto.'" height="200">';
	}
	
	





//lihat gambar
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'lihat2'))
	{
	$e_filex1 = "../../filebox/warga/$wargakd/$pelkd/$pelkd-2.jpg";
	
	
	//nek null foto
	if (!file_exists($e_filex1))
		{
		$nil_foto = "$sumber/template/img/bg-black.png";
		}
	else
		{
		$nil_foto = "$sumber/filebox/warga/$wargakd/$pelkd/$pelkd-2.jpg";
		}
		

	echo '<img src="'.$nil_foto.'" height="200">';
	}






//lihat gambar
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'lihat3'))
	{
	$e_filex1 = "../../filebox/warga/$wargakd/$pelkd/$pelkd-3.jpg";
	
	
	//nek null foto
	if (!file_exists($e_filex1))
		{
		$nil_foto = "$sumber/template/img/bg-black.png";
		}
	else
		{
		$nil_foto = "$sumber/filebox/warga/$wargakd/$pelkd/$pelkd-3.jpg";
		}
		

	echo '<img src="'.$nil_foto.'" height="200">';
	}





/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>