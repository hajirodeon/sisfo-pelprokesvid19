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
$filenya = "petugas.php";
$judul = "Data User Petugas";
$judul = "[USER]. Data User Petugas";
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
//jika export
//export
if ($_POST['btnEX'])
	{
	//require
	require('../../inc/class/excel/OLEwriter.php');
	require('../../inc/class/excel/BIFFwriter.php');
	require('../../inc/class/excel/worksheet.php');
	require('../../inc/class/excel/workbook.php');


	//nama file e...
	$i_filename = "user_petugas.xls";
	$i_judul = "User_petugas";
	



	//header file
	function HeaderingExcel($i_filename)
		{
		header("Content-type:application/vnd.ms-excel");
		header("Content-Disposition:attachment;filename=$i_filename");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
		header("Pragma: public");
		}

	
	
	
	//bikin...
	HeaderingExcel($i_filename);
	$workbook = new Workbook("-");
	$worksheet1 =& $workbook->add_worksheet($i_judul);
	$worksheet1->write_string(0,0,"NO.");
	$worksheet1->write_string(0,1,"KODE");
	$worksheet1->write_string(0,2,"NAMA");
	$worksheet1->write_string(0,3,"JABATAN");
	$worksheet1->write_string(0,4,"TELP");
	$worksheet1->write_string(0,5,"EMAIL");
	$worksheet1->write_string(0,6,"USERNAME");
	$worksheet1->write_string(0,7,"PASSWORD");



	//data
	$qdt = mysqli_query($koneksi, "SELECT * FROM m_petugas ".
									"WHERE tipe_user = 'PETUGAS' ".
									"ORDER BY kode ASC");
	$rdt = mysqli_fetch_assoc($qdt);

	do
		{
		//nilai
		$dt_nox = $dt_nox + 1;
		$dt_kode = balikin($rdt['kode']);
		$dt_nama = balikin($rdt['nama']);
		$dt_jabatan = balikin($rdt['jabatan']);
		$dt_telp = balikin($rdt['telp']);
		$dt_email = balikin($rdt['email']);
		$dt_usernamex = balikin($rdt['usernamex']);
		$dt_passwordx = balikin($rdt['passwordx']);



		//ciptakan
		$worksheet1->write_string($dt_nox,0,$dt_nox);
		$worksheet1->write_string($dt_nox,1,$dt_kode);
		$worksheet1->write_string($dt_nox,2,$dt_nama);
		$worksheet1->write_string($dt_nox,3,$dt_jabatan);
		$worksheet1->write_string($dt_nox,4,$dt_telp);
		$worksheet1->write_string($dt_nox,5,$dt_email);
		$worksheet1->write_string($dt_nox,6,$dt_usernamex);
		$worksheet1->write_string($dt_nox,7,$dt_passwordx);
		}
	while ($rdt = mysqli_fetch_assoc($qdt));


	//close
	$workbook->close();

	
	
	//re-direct
	xloc($filenya);
	exit();
	}












//nek batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}








//nek baru
if ($_POST['btnBR'])
	{
	//re-direct
	$ke = "$filenya?s=baru&kd=$x";
	xloc($ke);
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






//nek pegawai : reset
if ($s == "reset")
	{ 
	//nilai
	$nilku = rand(11111,99999);
	
	//pass baru
	$passbarux = $nilku;
	
	
	//update
	mysqli_query($koneksi, "UPDATE m_petugas SET passwordx = '$passbarux' ".
					"WHERE tipe_user = 'PETUGAS' ".
					"AND kd = '$kd'"); 
	
	//re-direct
	$pesan = "Password Baru : $nilku";
	pekem($pesan,$filenya);
	exit();
	}








//jika simpan
if ($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$page = nosql($_POST['page']);;
	$e_kode = cegah($_POST['e_kode']);
	$e_nama = cegah($_POST['e_nama']);
	$e_jabatan = cegah($_POST['e_jabatan']);
	$e_telp = cegah($_POST['e_telp']);
	$e_email = cegah($_POST['e_email']);
	$e_userx = cegah($_POST['e_userx']);
	$e_passx = cegah($_POST['e_passx']);



	//nek null
	if ((empty($e_kode)) OR (empty($e_telp)) OR (empty($e_nama)))
		{
		//re-direct
		$pesan = "Belum Ditulis. Harap Diulangi...!!";
		$ke = "$filenya?s=$s&kd=$kd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//set akses 
		$aksesnya = $e_kode;
		$passx = $aksesnya;
		
		
		//jika insert
		if ($s == "baru")
			{
			mysqli_query($koneksi, "INSERT INTO m_petugas(kd, tipe_user, kode, nama, ".
							"jabatan, telp, email, ".
							"usernamex, passwordx, postdate) VALUES ".
							"('$x', 'PETUGAS', '$e_kode', '$e_nama', ".
							"'$e_jabatan', '$e_telp', '$e_email', ".
							"'$aksesnya', '$passx', '$today')");


			//re-direct
			xloc($filenya);
			exit();
			}
			
			
			
		//jika update
		if ($s == "edit")
			{
			mysqli_query($koneksi, "UPDATE m_petugas SET kode = '$e_kode', ".
							"nama = '$e_nama', ".
							"jabatan = '$e_jabatan', ".
							"telp = '$e_telp', ".
							"email = '$e_email', ".
							"usernamex = '$aksesnya', ".
							"passwordx = '$passx' ".
							"WHERE tipe_user = 'PETUGAS' ".
							"AND kd = '$kd'");


			//re-direct
			xloc($filenya);
			exit();
			}
		}
	}








//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);
	$page = nosql($_POST['page']);
	$ke = "$filenya?page=$page";

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysqli_query($koneksi, "DELETE FROM m_petugas ".
						"WHERE tipe_user = 'PETUGAS' ".
						"AND kd = '$kd'");
		}

	//auto-kembali
	xloc($filenya);
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
  
<?php
//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika edit / baru
if (($s == "baru") OR ($s == "edit"))
	{
	$kdx = nosql($_REQUEST['kd']);

	$qx = mysqli_query($koneksi, "SELECT * FROM m_petugas ".
						"WHERE tipe_user = 'PETUGAS' ".
						"AND kd = '$kdx'");
	$rowx = mysqli_fetch_assoc($qx);
	$e_kode = balikin($rowx['kode']);
	$e_nama = balikin($rowx['nama']);
	$e_jabatan = balikin($rowx['jabatan']);
	$e_telp = balikin($rowx['telp']);
	$e_email = balikin($rowx['email']);
	$e_userx = balikin($rowx['usernamex']);
	$e_passx = balikin($rowx['passwordx']);
	
	
	echo '<form action="'.$filenya.'" method="post" name="formx2">';
	?>
	
	
	
	<div class="row">

	<div class="col-md-4">
		
	<?php
	echo '<p>
	KODE/NIK/NIP : 
	<br>
	<input name="e_kode" type="text" value="'.$e_kode.'" size="20" class="btn-warning" required>
	</p>
	
	
	<p>
	Nama : 
	<br>
	<input name="e_nama" type="text" value="'.$e_nama.'" size="30" class="btn-warning" required>
	</p>
	
	
	<p>
	Jabatan : 
	<br>
	<input name="e_jabatan" type="text" value="'.$e_jabatan.'" size="20" class="btn-warning" required>
	</p>';
	?>

	</div>
	
	<div class="col-md-4">
	
	<?php
	echo '<p>
	Telepon/HP/WA : 
	<br>
	<input name="e_telp" type="text" value="'.$e_telp.'" size="30" class="btn-warning" required>
	</p>
	
	
	
	<p>
	E-Mail : 
	<br>
	<input name="e_email" type="text" value="'.$e_email.'" size="30" class="btn-warning" required>
	</p>';
	?>

	</div>
	
	<div class="col-md-4">
	
	<?php
	echo '<p>
	Username : 
	<br>
	<input name="e_userx" type="text" value="'.$e_userx.'" size="10" class="btn-warning" required>
	</p>
	
	
	<p>
	Password : 
	<br>
	<input name="e_passx" type="text" value="'.$e_passx.'" size="10" class="btn-warning" required>
	</p>';
	?>
	
	

	</div>
	
	</div>
	
	

	<hr>
	
	<?php
	echo '<input name="jml" type="hidden" value="'.$count.'">
	<input name="s" type="hidden" value="'.$s.'">
	<input name="kd" type="hidden" value="'.$kdx.'">
	<input name="page" type="hidden" value="'.$page.'">
	
	<input name="btnSMP" type="submit" value="SIMPAN" class="btn btn-danger">
	<input name="btnBTL" type="submit" value="BATAL" class="btn btn-info">
	</form>';
	}
	




















else
	{
	//jika null
	if (empty($kunci))
		{
		$sqlcount = "SELECT * FROM m_petugas ".
						"WHERE tipe_user = 'PETUGAS' ".
						"ORDER BY kode ASC";
		}
		
	else
		{
		$sqlcount = "SELECT * FROM m_petugas ".
						"WHERE tipe_user = 'PETUGAS' ".
						"AND (kode LIKE '%$kunci%' ".
						"OR nama LIKE '%$kunci%' ".
						"OR jabatan LIKE '%$kunci%' ".
						"OR telp LIKE '%$kunci%' ".
						"OR email LIKE '%$kunci%' ".
						"OR usernamex LIKE '%$kunci%') ".
						"ORDER BY kode ASC";
		}
		
		
	
	//query
	$p = new Pager();
	$start = $p->findStart($limit);
	
	$sqlresult = $sqlcount;
	
	$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);
	
	
	
	echo '<form action="'.$filenya.'" method="post" name="formxx">
	<p>
	<input name="btnBR" type="submit" value="ENTRI BARU" class="btn btn-danger">
	<input name="btnEX" type="submit" value="EXPORT" class="btn btn-success">
	</p>
	<br>
	
	</form>



	<form action="'.$filenya.'" method="post" name="formx">
	<p>
	<input name="kunci" type="text" value="'.$kunci2.'" size="20" class="btn btn-warning" placeholder="Kata Kunci...">
	<input name="btnCARI" type="submit" value="CARI" class="btn btn-danger">
	<input name="btnBTL" type="submit" value="RESET" class="btn btn-info">
	</p>
		
	
	<div class="table-responsive">          
	<table class="table" border="1">
	<thead>
	
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="20">&nbsp;</td>
	<td width="20">&nbsp;</td>
	<td><strong><font color="'.$warnatext.'">KODE</font></strong></td>
	<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
	<td><strong><font color="'.$warnatext.'">JABATAN</font></strong></td>
	<td><strong><font color="'.$warnatext.'">TELP</font></strong></td>
	<td><strong><font color="'.$warnatext.'">EMAIL</font></strong></td>
	<td><strong><font color="'.$warnatext.'">USERNAME</font></strong></td>
	<td><strong><font color="'.$warnatext.'">PASSWORD</font></strong></td>
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
			$i_kode = balikin($data['kode']);
			$i_nama = balikin($data['nama']);
			$i_jabatan = balikin($data['jabatan']);
			$i_telp = balikin($data['telp']);
			$i_email = balikin($data['email']);
			$i_userx = balikin($data['usernamex']);
			$i_passx = balikin($data['passwordx']);

			
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
	        </td>
	        <td>
			<a href="'.$filenya.'?s=edit&page='.$page.'&kd='.$i_kd.'"><img src="'.$sumber.'/template/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			<td>'.$i_kode.'</td>
			<td>'.$i_nama.'</td>
			<td>'.$i_jabatan.'</td>
			<td>'.$i_telp.'</td>
			<td>'.$i_email.'</td>
			<td>'.$i_userx.'</td>
			<td>
			'.$i_passx.'
			<hr>
			<a href="'.$filenya.'?s=reset&kd='.$i_kd.'" class="btn btn-primary">RESET PASSWORD >></a>
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
	
	<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$count.')" class="btn btn-primary">
	<input name="btnBTL" type="reset" value="BATAL" class="btn btn-warning">
	<input name="btnHPS" type="submit" value="HAPUS" class="btn btn-danger">
	
	</td>
	</tr>
	</table>
	</form>';
	}








//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>