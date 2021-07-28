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
require("../../inc/cek/admketua.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/adminketua.html");

nocache;

//nilai
$filenya = "orang.php";
$judul = "Per Pelanggar";
$judul = "[REKAP]. Per Pelanggar";
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
  
<?php
//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika null
if (empty($kunci))
	{
	$sqlcount = "SELECT * FROM m_warga ".
					"ORDER BY nama ASC";
	}
	
else
	{
	$sqlcount = "SELECT * FROM m_warga ".
					"WHERE nama LIKE '%$kunci%' ".
					"OR nik LIKE '%$kunci%' ".
					"OR lahir_tgl LIKE '%$kunci%' ".
					"OR telp LIKE '%$kunci%' ".
					"ORDER BY nama ASC";
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
<td><strong><font color="'.$warnatext.'">NAMA</font></strong></td>
<td><strong><font color="'.$warnatext.'">TGL_LAHIR</font></strong></td>
<td><strong><font color="'.$warnatext.'">TELP</font></strong></td>
<td><strong><font color="'.$warnatext.'">KETERANGAN</font></strong></td>
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
		$i_nama = balikin($data['nama']);
		$i_nik = balikin($data['nik']);
		$i_lahir_tgl = balikin($data['lahir_tgl']);
		$i_telp = balikin($data['telp']);

		
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		'.$i_nama.'
		<br>
		NIK. '.$i_nik.'
		</td>
		<td>'.$i_lahir_tgl.'</td>
		<td>'.$i_telp.'</td>
		<td>';
		
		//rincian pelanggaran
		$qmboh = mysqli_query($koneksi, "SELECT * FROM petugas_entri ".
											"WHERE warga_kd = '$i_kd' ".
											"ORDER BY postdate DESC");
		$rmboh = mysqli_fetch_assoc($qmboh);
		$tmboh = mysqli_num_rows($qmboh);
		
		
		echo '[<font color="red"><b>'.$tmboh.'</b></font> Pelanggaran].
		<hr>';
		
		
		//jika ada
		if (!empty($tmboh))
			{
			echo "<ul>";
			do
				{
				//nilai
				$mboh_postdate = balikin($rmboh['postdate']);
				$mboh_kec = balikin($rmboh['kecamatan']);
				$mboh_tempat = balikin($rmboh['alamat_googlemap']);
				
				echo "<li>[$mboh_postdate]. [$mboh_kec], $mboh_tempat </li>";	
				}
			while ($rmboh = mysqli_fetch_assoc($qmboh));
			
			echo "</ul>";
			}
		
		
		echo '</td>
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


//null-kan
xclose($koneksi);
exit();
?>