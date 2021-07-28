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
$filenya = "$sumber/admpetugas/d/i_entri.php";
$filenyax = "$sumber/admpetugas/d/i_entri.php";
$judul = "ENTRI";
$juduli = $judul;



//nilai session
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
$kuy_alamat = balikin($rkuy['alamat_googlemap']);
$kuy_kec = balikin($rkuy['kecamatan']);
$kuy_latx = balikin($rkuy['lat_x']);
$kuy_laty = balikin($rkuy['lat_y']);





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'simpan'))
	{
	//ambil nilai
	$e_nik = cegah($_GET["e_nik"]);
	$e_nama = cegah($_GET["e_nama"]);
	$e_nama2 = balikin($e_nama);
	$e_lahir_tgl = cegah($_GET["e_lahir_tgl"]);
	$e_telp = cegah($_GET["e_telp"]);
	$e_telp2 = balikin($e_telp);
	$f_alamat = balikin($_GET["f_alamat"]);
	$f_kec = balikin($_GET["f_kec"]);
	$f_latx = balikin($_GET["f_latx"]);
	$f_laty = balikin($_GET["f_laty"]);
	

	
	//pecah tanggal
	$tgl2_pecah = balikin($e_lahir_tgl);
	$tgl2_pecahku = explode("-", $tgl2_pecah);
	$tgl2_tgl = trim($tgl2_pecahku[2]);
	$tgl2_bln = trim($tgl2_pecahku[1]);
	$tgl2_thn = trim($tgl2_pecahku[0]);
	$e_lahir_tgl = "$tgl2_thn-$tgl2_bln-$tgl2_tgl";
		


		
	echo '<p>
	NIK :
	<br>
	<b>'.$e_nik.'</b>
	</p>
	
	<p>
	Nama :
	<br>
	<b>'.$e_nama2.'</b>
	</p>
	
	<p>
	Tanggal Lahir :
	<br>
	<b>'.$e_lahir_tgl.'</b>
	</p>
	
	<p>
	Telepon/WA :
	<br>
	<b>'.$e_telp2.'</b>
	</p>
	
	<hr>';		



	//wargakd tercipta dari nama dan tanggal lahir //////////////////////////////////////////////////
	$wargakd = md5("$e_nama$e_lahir_tgl"); 
	
	
	

	//jika ada NIK //////////////////////////////////////////////////////////////////////////////////
	if (!empty($e_nik))
		{
		//jika baru, entri ke master warga
		$qcc = mysqli_query($koneksi, "SELECT * FROM m_warga ".
											"WHERE nik = '$e_nik'");
		$rcc = mysqli_fetch_assoc($qcc);
		$tcc = mysqli_num_rows($qcc);
		$cc_kd = balikin($rcc['kd']);
		$cc_jml = balikin($rcc['jml_entri']);
		
		if (!empty($tcc))
			{
			//hitung jumlahnya
			$qku = mysqli_query($koneksi, "SELECT kd FROM petugas_entri ".
											"WHERE warga_kd = '$cc_kd'");
			$tku = mysqli_num_rows($qku);
			
			
			//set
			mysqli_query($koneksi, "UPDATE m_warga SET jml_entri = '$tku' ".
										"WHERE kd = '$cc_kd'");
										
									
			//bikin sesi		
			$wargakd = $cc_kd;
			$_SESSION['wargakd'] = $wargakd;
			}
		else
			{
			//entri baru
			mysqli_query($koneksi, "INSERT INTO m_warga(kd, nik, nama, ".
										"lahir_tgl, telp, postdate) VALUES ".
										"('$wargakd', '$e_nik', '$e_nama', ".
										"'$e_lahir_tgl', '$e_telp', '$today')");
								
			$_SESSION['wargakd'] = $wargakd;
			}
		}




	//jika gak pake nik, hanya nama dan tanggal lahir /////////////////////////////////////////////////
	else 
		{
		//jika baru, entri ke master warga
		$qcc = mysqli_query($koneksi, "SELECT * FROM m_warga ".
											"WHERE nama = '$e_nama' ".
											"AND round(DATE_FORMAT(lahir_tgl, '%d')) = '$tgl2_tgl' ".
											"AND round(DATE_FORMAT(lahir_tgl, '%m')) = '$tgl2_bln' ".
											"AND round(DATE_FORMAT(lahir_tgl, '%Y')) = '$tgl2_thn'");
		$rcc = mysqli_fetch_assoc($qcc);
		$tcc = mysqli_num_rows($qcc);
		$cc_kd = balikin($rcc['kd']);
		$cc_jml = balikin($rcc['jml_entri']);
		
		if (!empty($tcc))
			{
			//hitung jumlahnya
			$qku = mysqli_query($koneksi, "SELECT kd FROM petugas_entri ".
											"WHERE warga_kd = '$cc_kd'");
			$tku = mysqli_num_rows($qku);
			
			
			//set
			mysqli_query($koneksi, "UPDATE m_warga SET jml_entri = '$tku' ".
										"WHERE kd = '$cc_kd'");
										
					
			$wargakd = $cc_kd;	
			$_SESSION['wargakd'] = $cc_kd;
			}
		else
			{
			//entri baru
			mysqli_query($koneksi, "INSERT INTO m_warga(kd, nik, nama, ".
										"lahir_tgl, telp, postdate) VALUES ".
										"('$wargakd', '$e_nik', '$e_nama', ".
										"'$e_lahir_tgl', '$e_telp', '$today')");
										
					
			$_SESSION['wargakd'] = $wargakd;
			}
		}

	





		
	//query
	$xyz = $pelkd;
	mysqli_query($koneksi, "INSERT INTO petugas_entri(kd, petugas_kd, petugas_kode, ".
					"petugas_nama, petugas_tipe, ".
					"warga_kd, warga_nik, warga_nama, ".
					"warga_lahir_tgl, warga_telp, ".
					"alamat_googlemap, kecamatan, lat_x, lat_y, postdate) VALUES ".
					"('$xyz', '$kuy_kd', '$kuy_kode', ".
					"'$kuy_nama', '$kuy_tipe', ".
					"'$wargakd', '$e_nik', '$e_nama', ".
					"'$e_lahir_tgl', '$e_telp', ".
					"'$f_alamat', '$f_kec', '$f_latx', '$f_laty', '$today')");
	



	//bikin sesi
	$_SESSION['pelkd'] = $pelkd;

			
	//jumlah
	$qcc2 = mysqli_query($koneksi, "SELECT * FROM petugas_entri ".
									"WHERE warga_kd = '$wargakd' ".
									"ORDER BY postdate DESC");
	$rcc2 = mysqli_fetch_assoc($qcc2);
	$tcc2 = mysqli_num_rows($qcc2);

	echo '<a href="entri1.php" class="btn btn-block btn-danger">ENTRI FOTO SELFIE+KTP/FULL BADAN/BUKTI >></a>
	<hr>
	
	<h3>
	Jumlah Pelanggaran : 
	<b>
	<font color="red">'.$tcc2.'</font>
	</b>
	</h3>
	
	
	<hr>';
	
	
	//update kan ke warga
	mysqli_query($koneksi, "UPDATE m_warga SET jml_entri = '$tcc2' ".
								"WHERE kd = '$wargakd'");
	
	
	
	
	//jika ada
	if (!empty($tcc2))
		{
		do
			{
			//nilai
			$cc2_no = $cc2_no + 1;
			$cc2_alamat = balikin($rcc2['alamat_googlemap']);
			$cc2_latx = balikin($rcc2['lat_x']);
			$cc2_laty = balikin($rcc2['lat_y']);
			$cc2_postdate = balikin($rcc2['postdate']);
		
		
			echo '<p>
			'.$cc2_no.'. <font color="red"><b>'.$cc2_postdate.'</b></font>
			</p>
			
			<p>
			Alamat GoogleMap :
			<br>
			<b>'.$cc2_alamat.'</b>
			<br>
			<i>'.$cc2_latx.', '.$cc2_laty.', </i>
			</p>
			
			<hr>';		
			}
		while ($rcc2 = mysqli_fetch_assoc($qcc2));
		}	
	
	







	//entri history
	$todayx = $today;
	$ket = cegah("[$e_nik. $e_nama. $e_lahir_tgl. $e_telp]. $kuy_alamat. Postdate : $todayx");
	
	
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
	//nilai
	$pelkd = $_SESSION['pelkd'];
	
	?>


	<script language='javascript'>
	//membuat document jquery
	$(document).ready(function(){


		$('#e_nik').hide();
		$('#prosesya').hide();
		
		
		
		$("#btnKIRIM").on('click', function(){

			$("#formx2").submit(function(){
				$('#prosesya').show();
				
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





		$("#e_fnik").on('change', function(){
			var e_fnik = $('#e_fnik').val();
			
			//jika true
			if (e_fnik == "true")
				{
				$('#e_nik').show();
				}
				
			//jika false
			else if (e_fnik == "false")
				{
				$('#e_nik').hide();
				}
				
		});	





	
	});
	
	</script>


	
	              	

	
	<script language='javascript'>
	//membuat document jquery
	$(document).ready(function(){
	
	$.noConflict();

		  $('#e_nik').bind('keyup paste', function(){
	        this.value = this.value.replace(/[^0-9]/g, '');
	  		});
		
	});
	
	</script>
	


	
	<br>


	<table width="100%" border="0" cellpadding="5" cellspacing="5">
	<tr align="top">

	<td width="10">&nbsp;</td>
	<td valign="top">
			
	<div class="row">

		<div class="col-4" align="left">
			<div class="box box-danger">
			<div class="box-body">
			<div class="row">
				<div class="col-md-12">

					<div id="ihasil">

					<?php
					echo '<form name="formx2" id="formx2">
					<p>
					NIK : 
					<br>
					
					<select name="e_fnik" id="e_fnik" class="btn btn-warning" required>
					<option value="" selected></option>
					<option value="true">ADA</option>
					<option value="false">Tidak Ada</option>
					</select>
					
					
					<input name="e_nik" id="e_nik" type="text" size="10" class="btn btn-block btn-warning">
					</p>
					
					<p>
					Nama :
					<br>
					<input name="e_nama" id="e_nama" type="text" class="btn btn-block btn-warning" required>
					</p>
					
					<p>
					Tanggal Lahir :
					<br>
					<input name="e_lahir_tgl" id="e_lahir_tgl" type="date" size="10" class="btn btn-warning" required>
					</p>
					
					<p>
					Telepon/HP/WA :
					<br>
					<input name="e_telp" id="e_telp" type="text" class="btn btn-block btn-warning" required>
					</p>
										
					<p>
					<input name="pelkd" id="pelkd" type="hidden" value="'.$pelkd.'">
					<input name="f_alamat" id="f_alamat" type="hidden" value="'.$kuy_alamat.'">
					<input name="f_kec" id="f_kec" type="hidden" value="'.$kuy_kec.'">
					<input name="f_latx" id="f_latx" type="hidden" value="'.$kuy_latx.'">
					<input name="f_laty" id="f_laty" type="hidden" value="'.$kuy_laty.'">
					<input name="btnKIRIM" id="btnKIRIM" type="submit" value="KIRIM >>" class="btn btn-block btn-danger">
					</p>
					
					</form>
					
					<div id="prosesya">
						<img src="../../img/progress-bar.gif" width="100" height="16">
					
					</div>
					
					
					<br>
					<br>
					<br>
					<br>
					<br>';
					?>
					
						

					</div>

					
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
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>