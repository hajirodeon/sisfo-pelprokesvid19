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
require("../../inc/cek/admpetugas.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/adminpetugas.html");

nocache;

//nilai
$filenya = "entri.php";
$filenyax = "$sumber/admpetugas/d/i_entri.php";
$judul = "Entri Data Pelanggar";
$judulku = "$judul";
$judulx = $judul;





//hapus sesi lama dulu
$_SESSION['pelkd'] = '';
$_SESSION['wargakd'] = '';


//bikin sesi
$pelkd = $x;
$_SESSION['pelkd'] = $pelkd;





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


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

?>





<script>
$(document).ready(function(){


$(document).ajaxStart(function() 
	{
	$('#loading').show();
	}).ajaxStop(function() 
	{
	$('#loading').hide();
	});




$.ajax({
	url: "i_entri.php?aksi=form",
	type:$(this).attr("method"),
	data:$(this).serialize(),
	success:function(data){		
		$("#isinya").html(data);
		}
	});






})
</script>


<div id="isinya">

	<img src="img/progress-bar.gif" width="100" height="16">

</div>




<?php

	
//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>