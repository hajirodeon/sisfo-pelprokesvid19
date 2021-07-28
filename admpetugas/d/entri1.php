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
$tpl = LoadTpl("../../template/adminpetugas.html");

nocache;

//nilai
$filenya = "entri1.php";
$filenyax = "$sumber/admpetugas/d/i_entri1.php";
$judul = "Entri Data Pelanggar";
$judulku = "$judul";
$judulx = $judul;
$wargakd = cegah($_SESSION['wargakd']);
$pelkd = cegah($_SESSION['pelkd']);






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


$.ajax({
	url: "i_entri1.php?aksi=form",
	type:$(this).attr("method"),
	data:$(this).serialize(),
	success:function(data){		
		$("#isinya").html(data);
		}
	});


})
</script>







<div id="isinya">
	<img src="../../img/progress-bar.gif" width="100" height="16">
</div>

<hr>



	
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
	
	<b>FOTO SELFIE+KTP :<b> 
   <form method="post" id="upload_image" enctype="multipart/form-data">
	<input type="file" name="image_upload" id="image_upload" class="btn btn-warning"  accept=".jpg, .jpeg, .png" required>

   </form>
   
   <hr>';
	
	?>
	
	
	<script>  
	$(document).ready(function(){
		
	       $('#image-holder').load("<?php echo $sumber;?>/admpetugas/d/i_entri1.php?aksi=lihat&&wargakd=<?php echo $wargakd;?>&pelkd=<?php echo $pelkd;?>");

	
	
	        
	    $('#upload_image').on('change', function(event){
	     event.preventDefault();
	     
			$('#loading').show();
	
	
		
		     $.ajax({
		      url:"<?php echo $sumber;?>/admpetugas/d/i_entri1_upload.php?wargakd=<?php echo $wargakd;?>&pelkd=<?php echo $pelkd;?>",
		      method:"POST",
		      data:new FormData(this),
		      contentType:false,
		      cache:false,
		      processData:false,
		      success:function(data){
				$('#loading').hide();
		       $('#preview').load("<?php echo $sumber;?>/admpetugas/d/i_entri1.php?aksi=lihat&&wargakd=<?php echo $wargakd;?>&pelkd=<?php echo $pelkd;?>");
		       	
		      }
		     })
		    });
		    
		    
	});  
	</script>






	




	
	
		<table border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td width="100">
			<div id="image-holder2"></div>
		</td>
		

		</tr>
		</table>
	
	<script>
	$(document).ready(function() {
		
		
	        $("#image_upload2").on('change', function() {
	          //Get count of selected files
	          var countFiles = $(this)[0].files.length;
	          var imgPath = $(this)[0].value;
	          var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
	          var image_holder = $("#image-holder2");
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
	echo '<div id="loading2" style="display:none">
	<img src="'.$sumber.'/template/img/progress-bar.gif" width="100" height="16">
	</div>
	
	<b>FOTO FULL BADAN :<b> 
   <form method="post" id="upload_image2" enctype="multipart/form-data">
	<input type="file" name="image_upload2" id="image_upload2" class="btn btn-warning"  accept=".jpg, .jpeg, .png" required>

   </form>
   
   <hr>';
	
	?>
	
	
	<script>  
	$(document).ready(function(){
		
	       $('#image-holder2').load("<?php echo $sumber;?>/admpetugas/d/i_entri1.php?aksi=lihat2&wargakd=<?php echo $wargakd;?>&pelkd=<?php echo $pelkd;?>");

	
	
	        
	    $('#upload_image2').on('change', function(event){
	     event.preventDefault();
	     
			$('#loading2').show();
		
		     $.ajax({
		      url:"<?php echo $sumber;?>/admpetugas/d/i_entri1_upload2.php?wargakd=<?php echo $wargakd;?>&pelkd=<?php echo $pelkd;?>",
		      method:"POST",
		      data:new FormData(this),
		      contentType:false,
		      cache:false,
		      processData:false,
		      success:function(data){
		      	
				$('#loading2').hide();
		       $('#preview2').load("<?php echo $sumber;?>/admpetugas/d/i_entri1.php?aksi=lihat2&&wargakd=<?php echo $wargakd;?>&pelkd=<?php echo $pelkd;?>");
		       	
		      }
		     })
		    });
		    
		    
	});  
	</script>



















	
	
		<table border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td width="100">
			<div id="image-holder3"></div>
		</td>
		

		</tr>
		</table>
	
	<script>
	$(document).ready(function() {
		
		
	        $("#image_upload3").on('change', function() {
	          //Get count of selected files
	          var countFiles = $(this)[0].files.length;
	          var imgPath = $(this)[0].value;
	          var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
	          var image_holder = $("#image-holder3");
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
	echo '<div id="loading3" style="display:none">
	<img src="'.$sumber.'/template/img/progress-bar.gif" width="100" height="16">
	</div>
	
	<b>FOTO BUKTI :<b> 
   <form method="post" id="upload_image3" enctype="multipart/form-data">
	<input type="file" name="image_upload3" id="image_upload3" class="btn btn-warning"  accept=".jpg, .jpeg, .png" required>

   </form>
   
   <hr>';
	
	?>
	
	
	<script>  
	$(document).ready(function(){
		
	       $('#image-holder3').load("<?php echo $sumber;?>/admpetugas/d/i_entri1.php?aksi=lihat3&wargakd=<?php echo $wargakd;?>&pelkd=<?php echo $pelkd;?>");

	
	
	        
	    $('#upload_image3').on('change', function(event){
	     event.preventDefault();
	     
			$('#loading3').show();
		
		     $.ajax({
		      url:"<?php echo $sumber;?>/admpetugas/d/i_entri1_upload3.php?wargakd=<?php echo $wargakd;?>&pelkd=<?php echo $pelkd;?>",
		      method:"POST",
		      data:new FormData(this),
		      contentType:false,
		      cache:false,
		      processData:false,
		      success:function(data){
		      	
				$('#loading3').hide();
		       $('#preview3').load("<?php echo $sumber;?>/admpetugas/d/i_entri1.php?aksi=lihat3&&wargakd=<?php echo $wargakd;?>&pelkd=<?php echo $pelkd;?>");
		       	
		      }
		     })
		    });
		    
		    
	});  
	</script>












<hr>

<a href="entri.php" style="font-size:24px" class="btn btn-block btn-success"><i class="fa fa-briefcase"></i> KIRIM LAPORAN >></a>







<?php
	
//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>