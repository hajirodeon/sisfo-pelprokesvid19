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
$tpl = LoadTpl("../../template/admin.html");

nocache;

//nilai
$filenya = "bulan.php";
$judul = "Per Bulan";
$judul = "[REKAP]. Per Bulan";
$judulku = "$judul";
$judulx = $judul;
$uthn = nosql($_REQUEST['uthn']);

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


echo '<div class="row">
	<div class="col-md-12">';
	

	echo "<p>
	Tahun : 
	<br>
	<select name=\"ublnx\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-warning\">";
	echo '<option value="'.$uthn.'" selected>'.$uthn.'</option>';
	
	for ($i=$tahun;$i<=$tahun+1;$i++)
		{
		echo '<option value="'.$filenya.'?uthn='.$i.'">'.$i.'</option>';
		}
				
	echo '</select>
	</p>		
	

	
	
	</div>
</div>

<hr>';


if (empty($uthn))
	{
	echo '<font color="red">
	<h3>TAHUN Belum Dipilih...!!</h3>
	</font>';
	}

	
else
	{
	echo '<div class="table-responsive">          
	<table class="table" border="1">
	<thead>
	
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="200"><strong><font color="'.$warnatext.'">BULAN</font></strong></td>
	<td><strong><font color="'.$warnatext.'">JUMLAH</font></strong></td>
	</tr>
	</thead>
	<tbody>';
	
	for ($k=1;$k<=12;$k++) 
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


		
		//jumlahnya
		$qku = mysqli_query($koneksi, "SELECT * FROM petugas_entri ".
										"WHERE round(DATE_FORMAT(postdate, '%m')) = '$k' ".
										"AND round(DATE_FORMAT(postdate, '%Y')) = '$uthn'");
		$rku = mysqli_fetch_assoc($qku);
		$tku = mysqli_num_rows($qku);

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$arrbln[$k].'</td>
		<td><font color="red">'.$tku.'</font></td>
		
		</tr>';
		}
	
	
	
	echo '</tbody>
	  </table>
	  </div>';

	}




//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>