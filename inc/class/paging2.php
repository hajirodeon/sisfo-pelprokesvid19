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




class Pager
{
var $target;
var $curpage;


//batas
function findStart($limit)
   	{
   	if ((!isset($_GET['page'])) || ($_GET['page'] == "1"))
   		{
   		$start = 0;
   		$_GET['page'] = 1;
   		}
     else
      	{
       	$start = ($_GET['page']-1) * $limit;
      	}

     return $start;
    }

//total halaman
function findPages($count, $limit)
    {
     $pages = (($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1;

     return $pages;
   	}

//penanda daftar halaman
function pageList($curpage, $pages, $target)
	{
    $page_list  = "";

	//jika $target kosong
	if ($target == "")
		{
		$xpage = "?page";
		}
	else
		{
		$xpage = "&page";
		}

    //awal-sebelumnya
   	if (($curpage != 1) && ($curpage))
		{
   		$page_list .= "| <a href=\"".$target."".$xpage."=1\" title=\"Awal\"><<</a> ";
   		}
	else
		{
		$page_list .= "| <font color='#CCCCCC'><<</font> ";
		}

   	if (($curpage-1) > 0)
   		{
   		$page_list .= "| <a href=\"".$target."".$xpage."=".($curpage-1)."\" title=\"Sebelumnya\"><</a> | ";
   		}
	else
		{
		$page_list .= "| <font color='#CCCCCC'><</font> | ";
		}


   	//selanjutnya-akhir
   	if (($curpage+1) <= $pages)
   		{
   		$page_list .= " <a href=\"".$target."".$xpage."=".($curpage+1)."\" title=\"Selanjutnya\">></a> ";
   		}
	else
		{
		$page_list .= " <font color='#CCCCCC'>></font> ";
		}

   	if (($curpage != $pages) && ($pages != 0))
   		{
   		$page_list .= "| <a href=\"".$target."".$xpage."=".$pages."\" title=\"Akhir\">>></a> |";
   		}
	else
		{
		$page_list .= "| <font color='#CCCCCC'>>></font> |";
		}

	$page_list .= "\n";

   	return $page_list;
   	}

//sebelumnya-selanjutnya
function nextPrev($curpage, $pages)
   	{
     $next_prev  = "";

     if (($curpage-1) <= 0)
   		{
   		$next_prev .= "Sebelumnya";
   		}
     else
   		{
   		$next_prev .= "<a href=\"".$target."".$xpage."=".($curpage-1)."\">Sebelumnya</a>";
   		}

   	$next_prev .= " | ";

   	if (($curpage+1) > $pages)
   		{
   		$next_prev .= "Selanjutnya";
  		}
   	else
   		{
   		$next_prev .= "<a href=\"".$target."".$xpage."=".($curpage+1)."\">Selanjutnya</a>";
   		}

   	return $next_prev;
   	}
}
?>