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





nocache;

//nilai
$filenya = "$sumber/index.php";
$filenya_ke = $sumber;
$judul = "LOGIN ADMIN";
$judulku = $judul;






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ((isset($_GET['aksi']) && $_GET['aksi'] == 'simpan'))
	{
	//ambil nilai
	$etipe = cegah($_GET['e_tipe']);
	$euser = cegah($_GET['usernamex']);
	$epass = md5(cegah($_GET['passwordx']));
	$epass2 = cegah($_GET['passwordx']);

	
	//empty
	if ((empty($etipe)) OR (empty($euser)) OR (empty($epass)))
		{
		echo '<b>
		<font color="red">GAGAL. SILAHKAN ULANGI LAGI...!!</font>
		</b>';
		exit();	
		} 
	else
		{
		//jika admin
		if ($etipe == "tp06")
			{
			//query
			$q = mysqli_query($koneksi, "SELECT * FROM adminx ".
								"WHERE usernamex = '$euser' ".
								"AND passwordx = '$epass'");
			$row = mysqli_fetch_assoc($q);
			$total = mysqli_num_rows($q);
		
			//cek login
			if (!empty($total))
				{
				session_start();
		
				//bikin session
				$_SESSION['kd6_session'] = nosql($row['kd']);
				$_SESSION['username6_session'] = $euser;
				$_SESSION['pass6_session'] = $epass;
				$_SESSION['adm_session'] = "Administrator";
				$_SESSION['hajirobe_session'] = $hajirobe;
		
	
	
				//re-direct
				$ke = "adm/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				echo '<b>
				<font color="red">PASSWORD SALAH. SILAHKAN ULANGI LAGI...!!</font>
				</b>';
				exit();	
				}
			}
								
		
		
		
		
		//jika petugas
		else if ($etipe == "tp03")
			{
			//query
			$q = mysqli_query($koneksi, "SELECT * FROM m_petugas ".
								"WHERE tipe_user = 'PETUGAS' ".
								"AND usernamex = '$euser' ".
								"AND passwordx = '$epass2'");
			$row = mysqli_fetch_assoc($q);
			$total = mysqli_num_rows($q);
		
			//cek login
			if (!empty($total))
				{
				//nilai
				$e_kode = balikin($row['kode']);
				$e_nama = balikin($row['nama']);
				
				//bikin session
				session_start();
				$_SESSION['kd3_session'] = nosql($row['kd']);
				$_SESSION['nama3_session'] = balikin($row['nama']);
				$_SESSION['username3_session'] = $euser;
				$_SESSION['pass3_session'] = $epass2;
				$_SESSION['adm_session'] = "PETUGAS";
				$_SESSION['hajirobe_session'] = $hajirobe;
		
	
	
				//re-direct
				$ke = "admpetugas/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				echo '<b>
				<font color="red">PASSWORD SALAH. SILAHKAN ULANGI LAGI...!!</font>
				</b>';
				exit();	
				}
			}


		
		
		//jika b.a.p
		else if ($etipe == "tp04")
			{
			//query
			$q = mysqli_query($koneksi, "SELECT * FROM m_petugas ".
								"WHERE tipe_user = 'PETUGAS' ".
								"AND usernamex = '$euser' ".
								"AND passwordx = '$epass2'");
			$row = mysqli_fetch_assoc($q);
			$total = mysqli_num_rows($q);
		
			//cek login
			if (!empty($total))
				{
				//nilai
				$e_kode = balikin($row['kode']);
				$e_nama = balikin($row['nama']);
				
				//bikin session
				session_start();
				
				$_SESSION['kd4_session'] = nosql($row['kd']);
				$_SESSION['nama4_session'] = balikin($row['nama']);
				$_SESSION['username4_session'] = $euser;
				$_SESSION['pass4_session'] = $epass2;
				$_SESSION['adm_session'] = "B.A.P";
				$_SESSION['hajirobe_session'] = $hajirobe;
		
	
	
				//re-direct
				$ke = "admbap/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				echo '<b>
				<font color="red">PASSWORD SALAH. SILAHKAN ULANGI LAGI...!!</font>
				</b>';
				exit();	
				}
			}


		
		//jika ketua
		else if ($etipe == "tp05")
			{
			//query
			$q = mysqli_query($koneksi, "SELECT * FROM m_petugas ".
								"WHERE tipe_user = 'KETUA' ".
								"AND usernamex = '$euser' ".
								"AND passwordx = '$epass2'");
			$row = mysqli_fetch_assoc($q);
			$total = mysqli_num_rows($q);
		
			//cek login
			if (!empty($total))
				{
				//nilai
				$e_kode = balikin($row['kode']);
				$e_nama = balikin($row['nama']);
				
				//bikin session
				session_start();
				
				$_SESSION['kd5_session'] = nosql($row['kd']);
				$_SESSION['nama5_session'] = balikin($row['nama']);
				$_SESSION['username5_session'] = $euser;
				$_SESSION['pass5_session'] = $epass2;
				$_SESSION['adm_session'] = "KETUA";
				$_SESSION['hajirobe_session'] = $hajirobe;
		
	
	
				//re-direct
				$ke = "admketua/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				echo '<b>
				<font color="red">PASSWORD SALAH. SILAHKAN ULANGI LAGI...!!</font>
				</b>';
				exit();	
				}
			}




								
		}	

	
	exit();
	}





/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







//diskonek
exit();
?>