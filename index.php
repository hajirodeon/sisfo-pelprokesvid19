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
require("inc/config.php");
require("inc/fungsi.php");
require("inc/koneksi.php");
$tpl = LoadTpl("template/login_admin.html");


nocache;

//nilai
$filenya = "$sumber/index.php";
$filenyax = "$sumber/i_login.php";
$filenya_ke = $sumber;
$judul = "LOGIN USER";
$judulku = $judul;






//isi *START
ob_start();

?>

	
	<script language='javascript'>
	//membuat document jquery
	$(document).ready(function(){
	
		$("#btnOK").on('click', function(){
			
			$("#formx").submit(function(){
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
	


	
	});
	
	</script>
	


<?php
//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" id="formx">


<p>
Tipe User :
<br>
<select name="e_tipe" id="e_tipe" class="btn btn-warning btn-block" required>
<option value="" selectd></option>
<option value="tp03">Petugas</option>
<option value="tp04">B.A.P</option>
<option value="tp05">Ketua</option>
<option value="tp06">Administrator</option>
</select>
</p>




<p>
Username :
<br>
<input name="usernamex" id="usernamex" type="text" size="15" class="btn btn-warning btn-block" required>
</p>


<p>
Password :
<br>
<input name="passwordx" id="passwordx" type="password" size="15" class="btn btn-warning btn-block" required>
</p>


<p>
<input name="btnOK" id="btnOK" type="submit" value="SIGN IN &gt;&gt;&gt;" class="btn btn-danger">
</p>


<div id="ihasil"></div>

</form>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>