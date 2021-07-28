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
require("../../inc/cek/admbap.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/adminbap.html");

nocache;

//nilai
$filenya = "entri.php";
$filenyax = "$sumber/admbap/d/i_entri.php";
$judul = "Entri B.A.P";
$judulku = "$judul";
$judulx = $judul;


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



//hapus sesi lama dulu
$_SESSION['pelkd'] = '';
$_SESSION['wargakd'] = '';



//ambil list yg belum ada entri bap
$qku = mysqli_query($koneksi, "SELECT * FROM petugas_entri ".
								"WHERE petugas_kode = '$sesiku' ".
								"AND bap_nomor IS NULL ".
								"ORDER BY postdate ASC");
$rku = mysqli_fetch_assoc($qku);
$tku = mysqli_num_rows($qku);
$wargakd = balikin($rku['warga_kd']);
$pelkd = balikin($rku['kd']);


//bikin sesi
$_SESSION['pelkd'] = $pelkd;
$_SESSION['wargakd'] = $wargakd;

	
//nilai session
$wargakd = cegah($_SESSION['wargakd']);
$pelkd = cegah($_SESSION['pelkd']);






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







//isi *START
ob_start();



//jml notif
$qyuk = mysqli_query($koneksi, "SELECT * FROM petugas_history_entri ".
									"WHERE petugas_kode = '$username4_session' ".
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




<?php
//jika ada
if (!empty($tku))
	{
	?>

	<div id="ihasil">
		
	
	
		
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
	
	
		<style type="text/css">
		.thumb-image{
		 float:left;
		 width:150px;
		 height:150px;
		 position:relative;
		 padding:5px;
		}
		</style>
		
		
		
		
			<table border="0" cellspacing="0" cellpadding="3">
			<tr valign="top">
			<td width="100">
				<div id="image-holder"></div>
			</td>
			
	
			</tr>
			</table>
		
		<script>
		$(document).ready(function() {
			
			
		        $("#image_upload").on('change', function() {
		          //Get count of selected files
		          var countFiles = $(this)[0].files.length;
		          var imgPath = $(this)[0].value;
		          var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
		          var image_holder = $("#image-holder");
		          image_holder.empty();
		          if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
		            if (typeof(FileReader) != "undefined") {
		              //loop for each file selected for uploaded.
		              for (var i = 0; i < countFiles; i++) 
		              {
		                var reader = new FileReader();
		                reader.onload = function(e) {
		                  $("<img />", {
		                    "src": e.target.result,
		                    "class": "thumb-image"
		                  }).appendTo(image_holder);
		                }
		                image_holder.show();
		                reader.readAsDataURL($(this)[0].files[i]);
		              }
		              
		
			    
		            } else {
		              alert("This browser does not support FileReader.");
		            }
		          } else {
		            alert("Pls select only images");
		          }
		        });
		        
		        
	
	
		        
		        
		        
		      });
		</script>
	
		<?php
		echo '<div id="loading" style="display:none">
		<img src="'.$sumber.'/template/img/progress-bar.gif" width="100" height="16">
		</div>
		
		<b>FOTO LEMBAR KERTAS B.A.P :<b> 
	   <form method="post" id="upload_image" enctype="multipart/form-data">
		<input type="file" name="image_upload" id="image_upload" class="btn btn-warning"  accept=".jpg, .jpeg, .png" required>
	
	   </form>
	   
	   <hr>';
		
		?>
		
		
		<script>  
		$(document).ready(function(){
			
		       $('#image-holder').load("<?php echo $sumber;?>/admbap/d/i_entri.php?aksi=lihat&&wargakd=<?php echo $wargakd;?>&pelkd=<?php echo $pelkd;?>");
	
		
		
		        
		    $('#upload_image').on('change', function(event){
		     event.preventDefault();
		     
				$('#loading').show();
		
		
			
			     $.ajax({
			      url:"<?php echo $sumber;?>/admbap/d/i_entri_upload.php?wargakd=<?php echo $wargakd;?>&pelkd=<?php echo $pelkd;?>",
			      method:"POST",
			      data:new FormData(this),
			      contentType:false,
			      cache:false,
			      processData:false,
			      success:function(data){
					$('#loading').hide();
			       $('#preview').load("<?php echo $sumber;?>/admbap/d/i_entri.php?aksi=lihat&&wargakd=<?php echo $wargakd;?>&pelkd=<?php echo $pelkd;?>");
			       	
			      }
			     })
			    });
			    
			    
		});  
		</script>
	
	
	
	
	
	
		<div id="isinya">
		
			<img src="img/progress-bar.gif" width="100" height="16">
		
		</div>
		
	</div>


<?php
	}

else
	{
	echo '<br>
	<hr>
	<font color="red">
	<h3>BELUM ADA DATA PELANGGARAN TERBARU.</h3>
	</font>
	<hr>';
	}


	
//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>