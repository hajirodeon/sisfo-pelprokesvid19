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
$judul = "Per BAP Pelanggaran";
$judul = "[REKAP]. Per BAP Pelanggaran";
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

//query
$limit = 10;
$p = new Pager();
$start = $p->findStart($limit);



$sqlcount = "SELECT * FROM m_jenis ".
					"ORDER BY nama ASC";

$sqlresult = $sqlcount;

$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysqli_fetch_array($result);



echo '<form action="'.$filenya.'" method="post" name="formx">
<div class="table-responsive">          
<table class="table" border="1">
<thead>

<tr valign="top" bgcolor="'.$warnaheader.'">
<td><strong><font color="'.$warnatext.'">HUKUMAN</font></strong></td>';

//list kecamatan
$qku = mysqli_query($koneksi, "SELECT * FROM m_kecamatan ".
									"ORDER BY kecamatan ASC");
$rku = mysqli_fetch_assoc($qku);

do
	{
	//nilai
	$ku_kec = balikin($rku['kecamatan']);
	
	echo '<td><strong><font color="'.$warnatext.'">'.$ku_kec.'</font></strong></td>';
	}
while ($rku = mysqli_fetch_assoc($qku));


echo '</tr>
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
		$i_kode = cegah($data['kode']);
		$i_nama = balikin($data['nama']);
		
		

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$i_nama.'</td>';
		



		
		//list kecamatan
		$qku = mysqli_query($koneksi, "SELECT * FROM m_kecamatan ".
											"ORDER BY kecamatan ASC");
		$rku = mysqli_fetch_assoc($qku);
		
		do
			{
			//nilai
			$ku_kec = balikin($rku['kecamatan']);
			$ku_kec2 = cegah($rku['kecamatan']);
			
			
			
			//ketahui jumlahnya
			$qyus = mysqli_query($koneksi, "SELECT * FROM petugas_entri ".
												"WHERE kecamatan = '$ku_kec2' ".
												"AND hukuman_jenis = '$i_kode'");
			$tyus = mysqli_num_rows($qyus);
			
			
			
			
			//jika ada
			if (!empty($tyus))
				{
				echo '<td align="center"><strong><font color="red">'.$tyus.'</font></strong></td>';
				}
			else
				{
				echo '<td align="center">-</td>';
				}
			}
		while ($rku = mysqli_fetch_assoc($qku));
		
				
		
		echo '</tr>';
		}
	while ($data = mysqli_fetch_assoc($result));
	}


echo '</tbody>
  </table>
  </div>


<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
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