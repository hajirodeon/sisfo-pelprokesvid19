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
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
require("../inc/cek/admpetugas.php");
require("../inc/class/paging.php");
$tpl = LoadTpl("../template/adminpetugas.html");


nocache;

//nilai
$filenya = "index.php";
$diload = "getLocation();";




//detail
$qku = mysqli_query($koneksi, "SELECT * FROM m_petugas ".
						"WHERE tipe_user = 'PETUGAS' ".
						"AND kode = '$username3_session'");
$rku = mysqli_fetch_assoc($qku);
$ku_kd = balikin($rku['kd']);
$ku_kode = balikin($rku['kode']);
$ku_nama = balikin($rku['nama']);
$ku_alamat = balikin($rku['alamat_googlemap']);
$ku_kec = balikin($rku['kecamatan']);
$ku_latx = balikin($rku['lat_x']);
$ku_laty = balikin($rku['lat_y']);
$ku_postdate_tugas = balikin($rku['postdate_tugas']);
								

$judul = "$ku_kode. $ku_nama";





//isi *START
ob_start();


?>




<p id="demoku"></p>

<script>
var xx = document.getElementById("demoku");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    xx.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
	
		$.ajax({
			url: "i_set_lokasi.php?aksi=pmasuk&latx="+position.coords.latitude+"&laty="+position.coords.longitude,
			type:$(this).attr("method"),
			data:$(this).serialize(),
			success:function(data){			
				$("#demoku").html(data);	
				}
			});
		return false;
}
</script>




<?php
echo '<div class="row">

  <div class="col-lg-12">
    <div class="info-box mb-3 bg-danger">
      <span class="info-box-icon"><i class="fas fa-user-secret"></i></span>

      <div class="info-box-content">
        <span class="info-box-number">
        		
        		<b>'.$judul.'<b>
			</span>
      </div>
      
    </div>

	</div>
</div>';




//isi
$judulku = ob_get_contents();
ob_end_clean();
              
















//postdate entri
$qyuk = mysqli_query($koneksi, "SELECT * FROM petugas_entri ".
									"WHERE petugas_kode = '$username3_session' ".
									"ORDER BY postdate DESC");
$ryuk = mysqli_fetch_assoc($qyuk);
$yuk_entri_terakhir = balikin($ryuk['postdate']);






//postdate entri
$qyuk = mysqli_query($koneksi, "SELECT * FROM petugas_login ".
									"WHERE petugas_kode = '$username3_session' ".
									"ORDER BY postdate DESC");
$ryuk = mysqli_fetch_assoc($qyuk);
$yuk_login_terakhir = balikin($ryuk['postdate']);








//postdate entri
$qyuk = mysqli_query($koneksi, "SELECT DISTINCT(lat_x) AS lokasiku ".
									"FROM petugas_history_gps ".
									"WHERE lat_x <> '' ".
									"AND petugas_kode = '$username3_session' ".
									"ORDER BY postdate DESC");
$ryuk = mysqli_fetch_assoc($qyuk);
$jml_gps = mysqli_num_rows($qyuk);






//total pelanggaran
$qyuk = mysqli_query($koneksi, "SELECT kd FROM petugas_entri ".
									"WHERE petugas_kode = '$username3_session' ".
									"ORDER BY postdate DESC");
$ryuk = mysqli_fetch_assoc($qyuk);
$jml_pelanggaran = mysqli_num_rows($qyuk);







//total pelanggar
$qyuk = mysqli_query($koneksi, "SELECT DISTINCT(warga_kd) AS total ".
									"FROM petugas_entri ".
									"WHERE petugas_kode = '$username3_session' ".
									"ORDER BY postdate DESC");
$ryuk = mysqli_fetch_assoc($qyuk);
$jml_warga = mysqli_num_rows($qyuk);











//total denda
$qyuk = mysqli_query($koneksi, "SELECT SUM(hukuman_denda) AS totalnya ".
									"FROM petugas_entri ".
									"WHERE petugas_kode = '$username3_session' ".
									"ORDER BY postdate DESC");
$ryuk = mysqli_fetch_assoc($qyuk);
$jml_denda = balikin($ryuk['totalnya']);













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

//tanggal sekarang
$m = date("m");
$de = date("d");
$y = date("Y");

//ambil 14hari terakhir
for($i=0; $i<=14; $i++)
	{
	$nilku = date('Ymd',mktime(0,0,0,$m,($de-$i),$y)); 

	echo "$nilku, ";
	}


//isi
$isi_data1 = ob_get_contents();
ob_end_clean();










//isi *START
ob_start();

//tanggal sekarang
$m = date("m");
$de = date("d");
$y = date("Y");

//ambil 14hari terakhir
for($i=0; $i<=14; $i++)
	{
	$nilku = date('Y-m-d',mktime(0,0,0,$m,($de-$i),$y)); 


	//pecah
	$ipecah = explode("-", $nilku);
	$itahun = trim($ipecah[0]);  
	$ibln = trim($ipecah[1]);
	$itgl = trim($ipecah[2]);    


	//ketahui ordernya...
	$qyuk = mysqli_query($koneksi, "SELECT * FROM petugas_login ".
							"WHERE petugas_kode = '$username3_session' ".
							"AND round(DATE_FORMAT(postdate, '%d')) = '$itgl' ".
							"AND round(DATE_FORMAT(postdate, '%m')) = '$ibln' ".
							"AND round(DATE_FORMAT(postdate, '%Y')) = '$itahun'");
	$tyuk = mysqli_num_rows($qyuk);
	
	if (empty($tyuk))
		{
		$tyuk = "1";
		}
		
	echo "$tyuk, ";
	}


//isi
$isi_data2 = ob_get_contents();
ob_end_clean();










//isi *START
ob_start();

//tanggal sekarang
$m = date("m");
$de = date("d");
$y = date("Y");

//ambil 14hari terakhir
for($i=0; $i<=14; $i++)
	{
	$nilku = date('Y-m-d',mktime(0,0,0,$m,($de-$i),$y)); 


	//pecah
	$ipecah = explode("-", $nilku);
	$itahun = trim($ipecah[0]);  
	$ibln = trim($ipecah[1]);
	$itgl = trim($ipecah[2]);    


	//ketahui 
	$qyuk = mysqli_query($koneksi, "SELECT * FROM petugas_entri ".
							"WHERE petugas_kode = '$username3_session' ".
							"AND round(DATE_FORMAT(postdate, '%d')) = '$itgl' ".
							"AND round(DATE_FORMAT(postdate, '%m')) = '$ibln' ".
							"AND round(DATE_FORMAT(postdate, '%Y')) = '$itahun'");
	$tyuk = mysqli_num_rows($qyuk);
	
	if (empty($tyuk))
		{
		$tyuk = "1";
		}
		
	echo "$tyuk, ";
	}


//isi
$isi_data3 = ob_get_contents();
ob_end_clean();



















//isi *START
ob_start();

//ketahui ordernya...
$qyuk = mysqli_query($koneksi, "SELECT * FROM m_petugas ".
						"WHERE tipe_user = 'PETUGAS' ".
						"AND lat_x <> '' ".
						"AND kode = '$username3_session' ". 
						"ORDER BY postdate_tugas DESC LIMIT 0,1");
$ryuk = mysqli_fetch_assoc($qyuk);


do
	{
	//nilai
	$yuk_kode = balikin($ryuk['kode']);
	$yuk_nama = balikin($ryuk['nama']);
	$yuk_latx = balikin($ryuk['lat_x']);
	$yuk_laty = balikin($ryuk['lat_y']);
	

	
	
	echo "['$yuk_kode, $yuk_nama', $yuk_latx,$yuk_laty],";
	}
while ($ryuk = mysqli_fetch_assoc($qyuk));



//isi
$isi_gps2 = ob_get_contents();
ob_end_clean();












//isi *START
ob_start();


//ketahui ordernya...
$qyuk = mysqli_query($koneksi, "SELECT * FROM m_petugas ".
						"WHERE tipe_user = 'PETUGAS' ".
						"AND lat_x <> '' ". 
						"AND kode = '$username3_session' ".
						"ORDER BY postdate_tugas DESC LIMIT 0,1");
$ryuk = mysqli_fetch_assoc($qyuk);


do
	{
	//nilai
	$yuk_kode = balikin($ryuk['kode']);
	$yuk_nama = balikin($ryuk['nama']);
	$yuk_latx = balikin($ryuk['lat_x']);
	$yuk_laty = balikin($ryuk['lat_y']);
	$yuk_kec = balikin($ryuk['kecamatan']);
	$yuk_postdate = balikin($ryuk['postdate_tugas']);
	
	echo "['<div class=\"info_content\">' +
        '<h3>$yuk_nama</h3>' +
        '<p>$yuk_kode</p>' +
        '<p>Kecamatan : $yuk_kec</p>' +
        '<i>$yuk_postdate</i>' +        
        '</div>'],";	
	}
while ($ryuk = mysqli_fetch_assoc($qyuk));



//isi
$isi_gps3 = ob_get_contents();
ob_end_clean();


















//isi *START
ob_start();


?>







<style>
	#map_wrapper {
    height: 400px;
}

#map_canvas {
    width: 100%;
    height: 100%;
}
</style>


<h3>LOKASI SAAT INI</h3>
<div id="map_wrapper">
    <div id="map_canvas" class="mapping"></div>
</div>




<script>
	jQuery(function($) {
    // Asynchronously Load the map API 
    var script = document.createElement('script');
    script.src = "//maps.googleapis.com/maps/api/js?key=<?php echo $keyku;?>&sensor=false&callback=initialize";
    document.body.appendChild(script);
});

function initialize() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };
                    
    // Display a map on the page
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    map.setTilt(45);
        
    // Multiple Markers
    var markers = [<?php echo $isi_gps2;?>];
                        
    // Info Window Content
    var infoWindowContent = [<?php echo $isi_gps3;?>
    ];
        
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0]
        });
        
        // Allow each marker to have an info window    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Automatically center the map fitting all markers on the screen
        map.fitBounds(bounds);
    }

    // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(14);
        google.maps.event.removeListener(boundsListener);
    });
    
}
</script>
     

<br>     
     
     
     
<div class="row">
  <div class="col-lg-12">
    <div class="info-box mb-3 bg-warning">
      <span class="info-box-icon"><i class="fas fa-map"></i></span>

      <div class="info-box-content">
        <span class="info-box-number">
        		
			<p>
			Posisi Alamat Google MAP :
			<br>
			<b><?php echo $ku_alamat;?>, <br><?php echo $ku_latx;?>, <?php echo $ku_laty;?></b>
			</p>

			</span>
      </div>
    </div>

	</div>
	
</div>


     
     
     
     
<div class="row">

<div class="col-md-8">
 
     
		<!-- Info boxes -->
      <div class="row">



        <div class="col-md-12 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-calendar"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">LOGIN TERAKHIR</span>
              <span class="info-box-number"><?php echo $yuk_login_terakhir;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        





        <div class="col-md-12 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-calendar-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">ENTRI TERAKHIR</span>
              <span class="info-box-number"><?php echo $yuk_entri_terakhir;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        
                
      </div>
      <!-- /.row -->

	</div>

	<div class="col-md-4">

        <!-- Info Boxes Style 2 -->
            <div class="info-box mb-3 bg-danger">
              <span class="info-box-icon"><i class="fas fa-tag"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">TOTAL ENTRI PELANGGARAN</span>
                <span class="info-box-number"><?php echo $jml_pelanggaran;?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-primary">
              <span class="info-box-icon"><i class="fas fa-tag"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">TOTAL DENDA</span>
                <span class="info-box-number"><?php echo xduit2($jml_denda);?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
		
	</div>



</div>
 
     


      <div class="row">
        <div class="col-md-12">




			<script>
				$(function () {
				  'use strict'
				
				  var ticksStyle = {
				    fontColor: '#495057',
				    fontStyle: 'bold'
				  }
				
				  var mode      = 'index'
				  var intersect = true
				
				  var $salesChart = $('#sales-chart')
				  var salesChart  = new Chart($salesChart, {
				    type   : 'bar',
				    data   : {
				      labels  : [<?php echo $isi_bln3;?>],
				      datasets: [
				        {
				          backgroundColor: 'red',
				          borderColor    : 'red',
				          data           : [<?php echo $isi_bln3_demo1;?>]
				        },
				        {
				          backgroundColor: 'green',
				          borderColor    : 'green',
				          data           : [<?php echo $isi_bln3_demo2;?>]
				        },
				        {
				          backgroundColor: 'blue',
				          borderColor    : 'blue',
				          data           : [<?php echo $isi_bln3_demo3;?>]
				        },
				        {
				          backgroundColor: 'brown',
				          borderColor    : 'brown',
				          data           : [<?php echo $isi_bln3_demo4;?>]
				        },
				        {
				          backgroundColor: 'orange',
				          borderColor    : 'orange',
				          data           : [<?php echo $isi_bln3_demo5;?>]
				        }
				      ]
				    },
				    options: {
				      maintainAspectRatio: false,
				      tooltips           : {
				        mode     : mode,
				        intersect: intersect
				      },
				      hover              : {
				        mode     : mode,
				        intersect: intersect
				      },
				      legend             : {
				        display: false
				      },
				      scales             : {
				        yAxes: [{
				          // display: false,
				          gridLines: {
				            display      : true,
				            lineWidth    : '4px',
				            color        : 'rgba(0, 0, 0, .2)',
				            zeroLineColor: 'transparent'
				          },
				          ticks    : $.extend({
				            beginAtZero: true,
				
				            // Include a dollar sign in the ticks
				            callback: function (value, index, values) {
				              if (value >= 1000) {
				                value /= 1000
				                value += 'k'
				              }
				              return '' + value
				            }
				          }, ticksStyle)
				        }],
				        xAxes: [{
				          display  : true,
				          gridLines: {
				            display: false
				          },
				          ticks    : ticksStyle
				        }]
				      }
				    }
				  })
				
				  var $visitorsChart = $('#visitors-chart')
				  var visitorsChart  = new Chart($visitorsChart, {
				    data   : {
				      labels  : [<?php echo $isi_data1;?>],
				      datasets: [{
				        type                : 'line',
				        data                : [<?php echo $isi_data2;?>],
				        backgroundColor     : 'transparent',
				        borderColor         : '#007bff',
				        pointBorderColor    : '#007bff',
				        pointBackgroundColor: '#007bff',
				        fill                : false
				        // pointHoverBackgroundColor: '#007bff',
				        // pointHoverBorderColor    : '#007bff'
				      },
				        {
				          type                : 'line',
				          data                : [<?php echo $isi_data3;?>],
				          backgroundColor     : 'tansparent',
				          borderColor         : '#ced4da',
				          pointBorderColor    : '#ced4da',
				          pointBackgroundColor: '#ced4da',
				          fill                : false
				          // pointHoverBackgroundColor: '#ced4da',
				          // pointHoverBorderColor    : '#ced4da'
				        }]
				    },
				    options: {
				      maintainAspectRatio: false,
				      tooltips           : {
				        mode     : mode,
				        intersect: intersect
				      },
				      hover              : {
				        mode     : mode,
				        intersect: intersect
				      },
				      legend             : {
				        display: false
				      },
				      scales             : {
				        yAxes: [{
				          // display: false,
				          gridLines: {
				            display      : true,
				            lineWidth    : '4px',
				            color        : 'rgba(0, 0, 0, .2)',
				            zeroLineColor: 'transparent'
				          },
				          ticks    : $.extend({
				            beginAtZero : true,
				            suggestedMax: 200
				          }, ticksStyle)
				        }],
				        xAxes: [{
				          display  : true,
				          gridLines: {
				            display: false
				          },
				          ticks    : ticksStyle
				        }]
				      }
				    }
				  })
				})

			</script>









		<div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">History Online PETUGAS</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">



                <div class="position-relative mb-4">
                  <canvas id="visitors-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Login
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Entri Laporan
                  </span>
                </div>


                
                
              </div>
            </div>







		</div>


      </div>
            







		<!-- OPTIONAL SCRIPTS -->
		<script src="../template/adminlte3/plugins/chart.js/Chart.min.js"></script>
		




	
	<script language='javascript'>
	//membuat document jquery
	$(document).ready(function(){
	
	$.noConflict();

	});
	
	</script>
	


            
<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();




require("../inc/niltpl.php");

//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>