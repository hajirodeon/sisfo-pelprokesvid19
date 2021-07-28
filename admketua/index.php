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
require("../inc/cek/admketua.php");
require("../inc/class/paging.php");
$tpl = LoadTpl("../template/adminketua.html");


nocache;

//nilai
$filenya = "index.php";
$judul = "Admin KETUA";






//isi *START
ob_start();


echo '<div class="row">

  <div class="col-lg-12">
    <div class="info-box mb-3 bg-success">
      <span class="info-box-icon"><i class="fas fa-user-secret"></i></span>

      <div class="info-box-content">
        <span class="info-box-number">
        		KETUA/PIMPINAN
			</span>
      </div>
    </div>

	</div>
</div>';




//isi
$judulku = ob_get_contents();
ob_end_clean();
              














//jml petugas
$qyuk = mysqli_query($koneksi, "SELECT DISTINCT(kode) FROM m_petugas");
$jml_petugas = mysqli_num_rows($qyuk);













//postdate entri
$qyuk = mysqli_query($koneksi, "SELECT * FROM petugas_entri ".
									"ORDER BY postdate DESC");
$ryuk = mysqli_fetch_assoc($qyuk);
$yuk_entri_terakhir = balikin($ryuk['postdate']);






//postdate entri
$qyuk = mysqli_query($koneksi, "SELECT * FROM petugas_login ".
									"ORDER BY postdate DESC");
$ryuk = mysqli_fetch_assoc($qyuk);
$yuk_login_terakhir = balikin($ryuk['postdate']);








//postdate entri
$qyuk = mysqli_query($koneksi, "SELECT DISTINCT(lat_x) AS lokasiku ".
									"FROM petugas_history_gps ".
									"WHERE lat_x <> '' ".
									"ORDER BY postdate DESC");
$ryuk = mysqli_fetch_assoc($qyuk);
$jml_gps = mysqli_num_rows($qyuk);






//total pelanggaran
$qyuk = mysqli_query($koneksi, "SELECT kd FROM petugas_entri ".
									"ORDER BY postdate DESC");
$ryuk = mysqli_fetch_assoc($qyuk);
$jml_pelanggaran = mysqli_num_rows($qyuk);




//total bap
$qyuk = mysqli_query($koneksi, "SELECT kd FROM petugas_entri ".
									"WHERE bap_nomor <> '' ".
									"ORDER BY postdate DESC");
$ryuk = mysqli_fetch_assoc($qyuk);
$jml_bap = mysqli_num_rows($qyuk);






//total pelanggar
$qyuk = mysqli_query($koneksi, "SELECT DISTINCT(warga_kd) AS total ".
									"FROM petugas_entri ".
									"ORDER BY postdate DESC");
$ryuk = mysqli_fetch_assoc($qyuk);
$jml_warga = mysqli_num_rows($qyuk);











//total denda
$qyuk = mysqli_query($koneksi, "SELECT SUM(hukuman_denda) AS totalnya ".
									"FROM petugas_entri ".
									"ORDER BY postdate DESC");
$ryuk = mysqli_fetch_assoc($qyuk);
$jml_denda = balikin($ryuk['totalnya']);













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
							"WHERE round(DATE_FORMAT(postdate, '%d')) = '$itgl' ".
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
							"WHERE round(DATE_FORMAT(postdate, '%d')) = '$itgl' ".
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
						"ORDER BY postdate_tugas DESC LIMIT 0,100");
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
						"ORDER BY postdate_tugas DESC LIMIT 0,100");
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

//list kecamatan
$qku = mysqli_query($koneksi, "SELECT * FROM m_kecamatan ".
								"ORDER BY kecamatan ASC");
$rku = mysqli_fetch_assoc($qku);

do
	{
	//nilai
	$i_kec = balikin($rku['kecamatan']);
	
	echo "'$i_kec', ";	
	}
while ($rku = mysqli_fetch_assoc($qku));



//isi
$isi_bln3 = ob_get_contents();
ob_end_clean();







//isi *START
ob_start();





//list kecamatan
$qku = mysqli_query($koneksi, "SELECT * FROM m_kecamatan ".
								"ORDER BY kecamatan ASC");
$rku = mysqli_fetch_assoc($qku);

do
	{
	//nilai
	$i_kec = cegah($rku['kecamatan']);
	
	//detailnya
	$qyuk2 = mysqli_query($koneksi, "SELECT kd FROM petugas_entri ".
									"WHERE kecamatan = '$i_kec' ".
									"AND hukuman_jenis = 'J001'");
	$tyuk2 = mysqli_num_rows($qyuk2);
	
	
	echo "'$tyuk2', ";	
	}
while ($rku = mysqli_fetch_assoc($qku));




//isi
$isi_bln3_demo1 = ob_get_contents();
ob_end_clean();







//isi *START
ob_start();



//list kecamatan
$qku = mysqli_query($koneksi, "SELECT * FROM m_kecamatan ".
								"ORDER BY kecamatan ASC");
$rku = mysqli_fetch_assoc($qku);

do
	{
	//nilai
	$i_kec = cegah($rku['kecamatan']);
	
	//detailnya
	$qyuk2 = mysqli_query($koneksi, "SELECT kd FROM petugas_entri ".
									"WHERE kecamatan = '$i_kec' ".
									"AND hukuman_jenis = 'J002'");
	$tyuk2 = mysqli_num_rows($qyuk2);
	
	echo "'$tyuk2', ";	
	}
while ($rku = mysqli_fetch_assoc($qku));


//isi
$isi_bln3_demo2 = ob_get_contents();
ob_end_clean();







//isi *START
ob_start();


//list kecamatan
$qku = mysqli_query($koneksi, "SELECT * FROM m_kecamatan ".
								"ORDER BY kecamatan ASC");
$rku = mysqli_fetch_assoc($qku);

do
	{
	//nilai
	$i_kec = cegah($rku['kecamatan']);


	/*	
	//detailnya
	$qyuk2 = mysqli_query($koneksi, "SELECT kd FROM petugas_entri ".
									"WHERE kec_nama = '$i_kec' ".
									"AND hukuman_jenis = 'J003'");
	$tyuk2 = mysqli_num_rows($qyuk2);
	*/
	
		
	//detailnya
	$qyuk2 = mysqli_query($koneksi, "SELECT kd FROM petugas_entri ".
									"WHERE kecamatan = '$i_kec'");
	$tyuk2 = mysqli_num_rows($qyuk2);
	
	
	echo "'$tyuk2', ";	
	}
while ($rku = mysqli_fetch_assoc($qku));


//isi
$isi_bln3_demo3 = ob_get_contents();
ob_end_clean();







//isi *START
ob_start();


//list kecamatan
$qku = mysqli_query($koneksi, "SELECT * FROM m_kecamatan ".
								"ORDER BY kecamatan ASC");
$rku = mysqli_fetch_assoc($qku);

do
	{
	//nilai
	$i_kec = cegah($rku['kecamatan']);
	
	//detailnya
	$qyuk2 = mysqli_query($koneksi, "SELECT kd FROM petugas_entri ".
									"WHERE kecamatan = '$i_kec' ".
									"AND hukuman_jenis = 'J004'");
	$tyuk2 = mysqli_num_rows($qyuk2);
	
	
	echo "'$tyuk2', ";	
	}
while ($rku = mysqli_fetch_assoc($qku));


//isi
$isi_bln3_demo4 = ob_get_contents();
ob_end_clean();











//isi *START
ob_start();


//list kecamatan
$qku = mysqli_query($koneksi, "SELECT * FROM m_kecamatan ".
								"ORDER BY kecamatan ASC");
$rku = mysqli_fetch_assoc($qku);

do
	{
	//nilai
	$i_kec = cegah($rku['kecamatan']);
	
	//detailnya
	$qyuk2 = mysqli_query($koneksi, "SELECT kd FROM petugas_entri ".
									"WHERE kecamatan = '$i_kec' ".
									"AND hukuman_jenis = 'J005'");
	$tyuk2 = mysqli_num_rows($qyuk2);
	
	
	echo "'$tyuk2', ";	
	}
while ($rku = mysqli_fetch_assoc($qku));


//isi
$isi_bln3_demo5 = ob_get_contents();
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


<h3>POSISI PETA SATGAS SAAT INI</h3>
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
     
     
     
     
     


	<!-- Info boxes -->
  <div class="row">


    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-orange"><i class="fa fa-users"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">PETUGAS</span>
          <span class="info-box-number"><?php echo $jml_petugas;?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-orange"><i class="fa fa-users"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">WARGA PELANGGAR</span>
          <span class="info-box-number"><?php echo $jml_warga;?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->




    <div class="col-md-3 col-sm-6 col-xs-12">
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
    





    <div class="col-md-3 col-sm-6 col-xs-12">
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



     
     
     
<div class="row">

	<div class="col-md-4">

        <!-- Info Boxes Style 2 -->
            <div class="info-box mb-3 bg-danger">
              <span class="info-box-icon"><i class="fas fa-tag"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">TOTAL PELANGGARAN</span>
                <span class="info-box-number"><?php echo $jml_pelanggaran;?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            
     </div>


	<div class="col-md-4">

        <!-- Info Boxes Style 2 -->
            <div class="info-box mb-3 bg-cyan">
              <span class="info-box-icon"><i class="fas fa-tag"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">TOTAL B.A.P</span>
                <span class="info-box-number"><?php echo $jml_bap;?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            
     </div>


     
	<div class="col-md-4">

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





			<div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">JUMLAH PELANGGARAN DAN SANKSI</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>

              <div class="card-body">

                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-red"></i> Teguran Lisan 
                  </span>

                  <span class="mr-2">
                    <i class="fas fa-square text-green"></i> Teguran Tertulis
                  </span>
                  
                  <span class="mr-2">
                    <i class="fas fa-square text-blue"></i> Kerja Sosial
                  </span>
                  
                  <span class="mr-2">
                    <i class="fas fa-square text-brown"></i> Denda
                  </span>
                  
                  <span class="mr-2">
                    <i class="fas fa-square text-orange"></i> Penghentian/Penutupan
                  </span>
                  
                </div>
              </div>
            </div>

			<hr>



		<div class="row">
          <div class="col-lg-8">

			<?php
			$sqlcount = "SELECT * FROM petugas_entri ".
							"ORDER BY postdate DESC";

			//query
			$p = new Pager();
			$start = $p->findStart($limit);
			
			$sqlresult = $sqlcount;
			
			$count = mysqli_num_rows(mysqli_query($koneksi, $sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysqli_fetch_array($result);
			?>
			
			
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">History Pelanggaran</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>POSTDATE</th>
                      <th>PELANGGAR</th>
                      <th>KETERANGAN</th>
                    </tr>
                    </thead>
                    <tbody>
                    	
                    <?php
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
							$i_postdate = balikin($data['postdate']);
							$i_alamat = balikin($data['alamat_googlemap']);
							$i_latx = balikin($data['lat_x']);
							$i_laty = balikin($data['lat_y']);
							$i_kec = balikin($data['kecamatan']);


							$i_wkd = balikin($data['warga_kd']);
							$i_wnik = balikin($data['warga_nik']);
							$i_wnama = balikin($data['warga_nama']);
							$i_wtgl = balikin($data['warga_lahir_tgl']);
							$i_wtelp = balikin($data['warga_telp']);

													
											
							$i_foto1 = "../filebox/warga/$i_wkd/$i_kd/$i_kd-1.jpg";
							$i_foto2 = "../filebox/warga/$i_wkd/$i_kd/$i_kd-2.jpg";
							$i_foto3 = "../filebox/warga/$i_wkd/$i_kd/$i_kd-3.jpg";
							$i_foto4 = "../filebox/warga/$i_wkd/$i_kd/$i_kd-4.jpg";
							
							
							$e_bap = balikin($data['bap_nomor']);
							$e_h_melanggar = balikin($data['hukuman_melanggar']);
							$e_h_jenis = balikin($data['hukuman_jenis']);
							$e_h_hukuman = balikin($data['hukuman_hukuman']);
							$e_h_postdate = balikin($data['hukuman_selesai_postdate']);
												
												
										
							//detail jenis
							$qkuy = mysqli_query($koneksi, "SELECT * FROM m_jenis ". 
																"WHERE kode = '$e_h_jenis'");
							$rkuy = mysqli_fetch_assoc($qkuy);
							$kuy_ket = balikin($rkuy['ket']);	
									
												
						
							echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
							echo '<td>'.$i_postdate.'</td>
							<td>
							'.$i_wnama.'
							<br>
							'.$i_wnik.'
							<hr>
							
							TanggalLahir:
							<br>'.$i_wtgl.'
							<hr>
							
							Telp.:
							<br>
							'.$i_wtelp.'
							
							</td>
							<td>
							'.$i_alamat.'
							<br>
							'.$i_latx.', '.$i_laty.'
							<br>

							<a href="'.$i_foto1.'" target="_blank"><img src="'.$i_foto1.'" width="150"></a>

							
							<a href="'.$i_foto2.'" target="_blank"><img src="'.$i_foto2.'" width="150"></a>

							
							<a href="'.$i_foto3.'" target="_blank"><img src="'.$i_foto3.'" width="150"></a>';

							
							//jika ada nomor BAP
							if (!empty($e_bap))
								{
								echo '<hr>
								
								Nomor BAP : 
								<br>
								<b>'.$e_bap.'</b>
								<br>
								<br>
								
								<b>'.$e_h_melanggar.'</b> 
								<br>
								<b>'.$kuy_ket.' '.$e_h_hukuman.'</b>
								<br>
								<br>
								
								<i>Postdate BAP : <br><b>'.$e_h_postdate.'</b></i>
								<br>
								
								<a href="'.$i_foto4.'" target="_blank"><img src="'.$i_foto4.'" width="200"></a>';
								}
							
							
							
							
							echo '</td>
					        </tr>';
							}
						while ($data = mysqli_fetch_assoc($result));
						?>
						
						
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="<?php echo $sumber;?>/admketua/h/pelanggaran.php" class="btn btn-sm btn-danger float-right">SELENGKAPNYA >></a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->


		</div>
		
		<div class="col-lg-4">

	
				<div class="card">
	              <div class="card-header border-transparent">
	                <h3 class="card-title">PERINGKAT PELANGGAR</h3>
	
	                <div class="card-tools">
	                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
	                    <i class="fas fa-minus"></i>
	                  </button>
	                </div>
	              </div>
	
	              <div class="card-body">
	
					<?php
					//total entri
					$qyuk2 = mysqli_query($koneksi, "SELECT SUM(jml_entri) AS totalnya ".
														"FROM m_warga ".
														"ORDER BY postdate DESC LIMIT 0,50");
					$ryuk2 = mysqli_fetch_assoc($qyuk2);
					$total_entri = balikin($ryuk2['totalnya']);
					
					
					//list 
					$qdt = mysqli_query($koneksi, "SELECT * FROM m_warga ".
													"ORDER BY round(jml_entri) DESC LIMIT 0,30");
					$rdt = mysqli_fetch_assoc($qdt);
				
					do
						{
						//nilai
						$dt_nox = $dt_nox + 1;
						$dt_kd = balikin($rdt['kd']);
						$dt_nik = balikin($rdt['nik']);
						$dt_lahir_tgl = balikin($rdt['lahir_tgl']);
						$dt_nama = balikin($rdt['nama']);
						$dt_telp = balikin($rdt['telp']);
						$dt_jml_entri = balikin($rdt['jml_entri']);
					

						//terakhir tertangkap
						$qyuk21 = mysqli_query($koneksi, "SELECT * FROM petugas_entri ".
															"WHERE warga_kd = '$dt_kd' ".
															"ORDER BY postdate DESC");
						$ryuk21 = mysqli_fetch_assoc($qyuk21);
						$yuk21_alamat = balikin($ryuk21['alamat_googlemap']);
						$yuk21_postdate = balikin($ryuk21['postdate']);
						
					

						//persen
						$ku_persen = ($dt_jml_entri / $total_entri) * 100; 

	                    echo '<div class="progress-group">
	                    '.$dt_nox.'. '.$dt_nama.' 
	                      <br>
	                      <b>NIK.</b>'.$dt_nik.'
	                      <br>
	                      <b>Tanggal Lahir :</b> '.$dt_lahir_tgl.'
	                      <br>
	                      <b>Telp :</b> '.$dt_telp.'
	                      <br>
	                      <b>Terakhir Tertangkap :</b> '.$yuk21_postdate.', <br><i>'.$yuk21_alamat.'</i>
	                      <span class="float-right"><b>'.$dt_jml_entri.'</b>/'.$total_entri.'</span>
	                      <div class="progress progress-sm">
	                        <div class="progress-bar bg-success" style="width: '.$ku_persen.'%"></div>
	                      </div>
	                    </div>
	                    <hr>
	                    <br>';
						}
					while ($rdt = mysqli_fetch_assoc($qdt));
						
					
					?>

	              </div>

	              <!-- /.card-body -->
	              <div class="card-footer clearfix">
	                <a href="<?php echo $sumber;?>/admketua/h/warga.php" class="btn btn-sm btn-danger float-right">SELENGKAPNYA >></a>
	              </div>
	              <!-- /.card-footer -->

	            </div>
	
				<br>
	




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