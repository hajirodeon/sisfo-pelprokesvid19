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




require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");



//ambil nilai
$wargakd = nosql($_REQUEST['wargakd']);
$pelkd = nosql($_REQUEST['pelkd']);




$foldernya = "../../filebox/warga/$wargakd";
chmod($foldernya, 0777);
			
			
//buat folder...
if (!file_exists('../../filebox/warga/'.$wargakd.'')) {
    mkdir('../../filebox/warga/'.$wargakd.'/', 0777, true);
	}






$foldernya = "../../filebox/warga/$wargakd/$pelkd";
chmod($foldernya, 0777);
			
			
//buat folder...
if (!file_exists('../../filebox/warga/'.$wargakd.'/'.$pelkd.'')) {
    mkdir('../../filebox/warga/'.$wargakd.'/'.$pelkd.'', 0777, true);
	}




$namabaru = "$pelkd-2.jpg";




//hapus dulu...
unlink($foldernya.$namabaru);









		  
//upload.php;
if(isset($_FILES["image_upload2"]["name"])) 
{
 $name = $_FILES["image_upload2"]["name"];
 $size = $_FILES["image_upload2"]["size"];
 $ext = end(explode(".", $name));
 $allowed_ext = array("png", "jpg", "jpeg");
 if(in_array($ext, $allowed_ext))
 {
//  if($size < (1024*1024))
  if($size < (5120*5120))
  {
   $new_image = '';
   $new_name = $namabaru;
   $path = "../../filebox/warga/$wargakd/$pelkd/$new_name";
   list($width, $height) = getimagesize($_FILES["image_upload2"]["tmp_name"]);
   if($ext == 'png')
   {
    $new_image = imagecreatefrompng($_FILES["image_upload2"]["tmp_name"]);
    
    chmod($path,0777);
    chmod($foldernya,0777);
   }
   if($ext == 'jpg' || $ext == 'jpeg')  
            {  
               $new_image = imagecreatefromjpeg($_FILES["image_upload2"]["tmp_name"]);  
            }
            //$new_width=200;
            $new_width=1000;
            $new_height = ($height/$width)*$new_width;
            //$new_height = 400;
            $tmp_image = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($tmp_image, $new_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            imagejpeg($tmp_image, $path, 80);
            imagedestroy($new_image);
            imagedestroy($tmp_image);
            echo '<img src="'.$path.'" width="100" height="100">';
			
			
    chmod($path,0777);
    chmod($foldernya,0777);
  }
  else
  {
   echo 'Image File size must be less than 5 MB';
  }
 }
 else
 {
  echo 'Invalid Image File';
 }
}
else
{
 echo 'Please Select Image File';
}



?>