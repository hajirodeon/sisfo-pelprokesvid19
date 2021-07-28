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
$filenya = "$sumber/admbap/d/i_entri.php";
$filenyax = "$sumber/admbap/d/i_entri.php";
$judul = "ENTRI";
$juduli = $judul;



//nilai session
$sesiku = cegah($_SESSION['username4_session']);



//detail
$qkuy = mysqli_query($koneksi, "SELECT * FROM m_petugas ".
						"WHERE tipe_user = 'PETUGAS' ".
						"AND kode = '$sesiku'");
$rkuy = mysqli_fetch_assoc($qkuy);
$kuy_kd = cegah($rkuy['kd']);
$kuy_kode = cegah($rkuy['kode']);
$kuy_nama = cegah($rkuy['nama']);
$kuy_tipe = cegah($rkuy['tipe_user']);
$kuy_alamat = balikin($rkuy['alamat_googlemap']);
$kuy_kec = balikin($rkuy['kecamatan']);
$kuy_latx = balikin($rkuy['lat_x']);
$kuy_laty = balikin($rkuy['lat_y']);



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'simpan'))
	{
	//ambil 
	$pelkd = cegah($_GET["pelkd"]);
	$wargakd = cegah($_GET["wargakd"]);
	
	$e_bap_nomor = cegah($_GET["e_bap_nomor"]);
	$e_isi = cegah($_GET["e_isi"]);
	$e_hukuman = cegah($_GET["e_hukuman"]);
	$e_nilai3 = cegah($_GET["e_nilai3"]);
	$e_nilai4 = cegah($_GET["e_nilai4"]); //denda
	$e_nilai5 = cegah($_GET["e_nilai5"]);
	$todayx = $today;




	//detail hukuman J001
	if ($e_hukuman == "J001")
		{
		$e_nilaiku = "Teguran Lisan.";
		}


	//detail hukuman J002
	if ($e_hukuman == "J002")
		{
		$e_nilaiku = "Teguran Tertulis.";
		}



	//cek
	if ($e_hukuman == "J003")
		{
		$e_nilaiku = $e_nilai3;
		}
				
			
	else if ($e_hukuman == "J004")
		{
		$e_nilaiku = $e_nilai4;
		}
		
	else if ($e_hukuman == "J005")
		{
		$e_nilaiku = $e_nilai5;
		}




	

	//query
	mysqli_query($koneksi, "UPDATE petugas_entri SET bap_nomor = '$e_bap_nomor', ".
					"hukuman_melanggar = '$e_isi', ".
					"hukuman_jenis = '$e_hukuman', ".
					"hukuman_hukuman = '$e_nilaiku', ".
					"hukuman_denda = '$e_nilai4', ".
					"hukuman_selesai_postdate = '$today' ".
					"WHERE kd = '$pelkd' ".
					"AND warga_kd = '$wargakd' ".
					"AND petugas_kode = '$sesiku'");
	

	
	
	

				
	echo '<br>
	<br>
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

					<font color="green">
					'.$todayx.'
					<h3>UPDATE BAP BERHASIL</h3>
					</font>
					<hr>
					<a href="entri.php" class="btn btn-block btn-danger"><i class="fa fa-briefcase"></i> ENTRI BAP LAINNYA >></a>
				
	

				
				</div>

					
    	    </div>
			</div>
			</div>
			</div>						

			
		</div>
	
	</td>

	<td width="10">&nbsp;</td>
	</tr>
	</table>';


	
	



	//detail
	$qcc = mysqli_query($koneksi, "SELECT * FROM m_warga ".
										"WHERE kd = '$wargakd'");
	$rcc = mysqli_fetch_assoc($qcc);
	$cc_nik = cegah($rcc['nik']);
	$cc_nama = cegah($rcc['nama']);
	$cc_lahir_tgl = cegah($rcc['lahir_tgl']);
	$cc_telp = cegah($rcc['telp']);



	//entri history
	$ket = cegah("UPDATE BAP $e_bap_nomor untuk [$cc_nik. $cc_nama. $cc_lahir_tgl. $cc_telp]. Postdate : $todayx");
	
	
	//query
	mysqli_query($koneksi, "INSERT INTO petugas_history_entri(kd, petugas_kd, petugas_kode, ".
					"petugas_nama, petugas_tipe, ket, postdate) VALUES ".
					"('$x', '$kuy_kd', '$kuy_kode', ".
					"'$kuy_nama', '$kuy_tipe', '$ket', '$todayx')");

	
	exit();
	}










//jika form
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'form'))
	{
	//nilai session
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
	
	
	
	//detail melanggar
	$qcc1 = mysqli_query($koneksi, "SELECT * FROM petugas_entri ".
										"WHERE kd = '$pelkd' ".
										"AND petugas_kode = '$sesiku'");
	$rcc1 = mysqli_fetch_assoc($qcc1);
	$cc1_alamat = balikin($rcc1['alamat_googlemap']);
	$cc1_postdate = balikin($rcc1['postdate']);
		
	
	?>




	<script language='javascript'>
	//membuat document jquery
	$(document).ready(function(){
	
	
		$('#ij003').hide();
		$('#ij004').hide();
		$('#ij005').hide();
				
				
		$("#btnKRM").on('click', function(){

			$("#formx2").submit(function(){
				$.ajax({
					url: "<?php echo $filenyax;?>?aksi=simpan",
					type:$(this).attr("method"),
					data:$(this).serialize(),
					success:function(data){					
						$("#ihasil").html(data);
						}
					});
				return false;

			});

		});	




		$("#e_hukuman").on('change', function(){
			var e_hukuman = $('#e_hukuman').val();
			
			//jika J003
			if (e_hukuman == "J003")
				{
				$('#ij003').show();
				$('#ij004').hide();
				$('#ij005').hide();
				}
				
			//jika J004
			else if (e_hukuman == "J004")
				{
				$('#ij003').hide();
				$('#ij004').show();
				$('#ij005').hide();
				}
				
			//jika J005
			else if (e_hukuman == "J005")
				{
				$('#ij003').hide();
				$('#ij004').hide();
				$('#ij005').show();
				}
			
		});	




	
	});
	
	</script>


		              	

	
	<script language='javascript'>
	//membuat document jquery
	$(document).ready(function(){
	
	$.noConflict();

	
		  $('#e_nilai4').bind('keyup paste', function(){
	        this.value = this.value.replace(/[^0-9]/g, '');
	  		});
		
	});
	
	</script>
	

	              	


	
	<br>

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
	<font color="red">
	<b>'.$cc_jml_entri.'</b>
	</font> kali.
	</p>
	
	<hr>
	<br>
	

	<form name="formx2" id="formx2">

	<p>			
	<font color="red">
	<h3>Melanggar pada : <br>'.$cc1_postdate.'</h3>
	<i>'.$cc1_alamat.'</i>
	</font>
	</p>
			
	<p>
	Menerangkan sebagai berikut : 
	<br>
	<textarea cols="100%" name="e_isi" id="e_isi" rows="5" wrap="yes" class="btn-block btn-warning" required>'.$e_isi.'</textarea>
	</p>


	
	<p>
	Pengenaan Sanksi Administrasi Berupa : 
	<br>
	<select name="e_hukuman" id="e_hukuman" class="btn btn-warning" required>
	<option value="" selected></option>';
	
	//list 
	$qku = mysqli_query($koneksi, "SELECT * FROM m_jenis ".
										"ORDER BY kode ASC");
	$rku = mysqli_fetch_assoc($qku);
	
	do
		{
		//nilai
		$i_kode = cegah($rku['kode']);
		$i_nama = cegah($rku['nama']);
		$i_nama2 = balikin($rku['nama']);
		
		echo '<option value="'.$i_kode.'">'.$i_nama2.'</option>';
		}
	while ($rku = mysqli_fetch_assoc($qku));
	
	
	echo '</select>
	</p>
	
	
	

	<div id="ij003">
	<p>
	Melaksanakan Kerja Sosial membersihkan fasilitas umum, berupa : 
	<br>
	<input name="e_nilai3" id="e_nilai3" type="text" value="'.$e_nilai3.'" class="btn btn-block btn-warning">
	</p>
	</div> 
	


	<div id="ij004">
	<p>
	Denda administratif sebesar : 
	<br>
	<select name="e_nilai4" id="e_nilai4" class="btn btn-warning">
	<option value="" selected></option>';
	
	//list 
	$qku = mysqli_query($koneksi, "SELECT * FROM m_denda ".
										"ORDER BY round(nama) ASC");
	$rku = mysqli_fetch_assoc($qku);
	
	do
		{
		//nilai
		$i_kode = cegah($rku['kode']);
		$i_nama = cegah($rku['nama']);
		
		echo '<option value="'.$i_nama.'">'.xduit2($i_nama).'</option>';
		}
	while ($rku = mysqli_fetch_assoc($qku));
	
	
	echo '</select>
	</p>
	</div> 


	<div id="ij005">
	<p>
	Penghentian atau penutupan sementara penyelenggaraan usaha/kegiatan :  
	<br>
	<input name="e_nilai5" id="e_nilai5" type="text" value="'.$e_nilai5.'" class="btn btn-block btn-warning">
	</p>
	</div> 


	
	<hr>

	<p>
	Nomor BAP 
	<br>
	<input name="e_bap_nomor" id="e_bap_nomor" type="text" value="" class="btn btn-block btn-warning" required>
	</p>
	
	<p>
	<input name="wargakd" id="wargakd" type="hidden" value="'.$wargakd.'">
	<input name="pelkd" id="pelkd" type="hidden" value="'.$pelkd.'">
	<input name="btnKRM" id="btnKRM" type="submit" value="KIRIM LAPORAN >>" class="btn btn-block btn-danger">
	</p>
	
	</form>
	
	<hr>';

					
	
	echo '<br>
	<br>
	<br>
	<br>
	<br>';
	
	exit();
	}	








//jika deteksi
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'deteksi'))
	{
	//nilai
	$jenis = cegah($_GET['jenis']);


	//jenis
	$qcc = mysqli_query($koneksi, "SELECT * FROM m_jenis ".
									"WHERE nama = '$jenis'");
	$rcc = mysqli_fetch_assoc($qcc);
	$tcc = mysqli_num_rows($qcc);
	$cc_ket = balikin($rcc['ket']);
	
	echo $cc_ket;		  
		
	exit();	
	}






//lihat gambar
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'lihat'))
	{
	$e_filex1 = "../../filebox/warga/$wargakd/$pelkd/$pelkd-4.jpg";
	
	
	//nek null foto
	if (!file_exists($e_filex1))
		{
		$nil_foto = "$sumber/template/img/bg-black.png";
		}
	else
		{
		$nil_foto = "$sumber/filebox/warga/$wargakd/$pelkd/$pelkd-4.jpg";
		}
		

	echo '<img src="'.$nil_foto.'" height="200">';
	}
	

	
		
?>