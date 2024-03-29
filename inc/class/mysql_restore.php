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



function split_sql2($sql)
	{
	$sql = trim($sql);
	$sql = ereg_replace("\n#[^\n]*\n", "\n", $sql);

	$buffer = array();
	$ret = array();
	$in_string = false;

	for($i=0; $i<strlen($sql)-1; $i++)
		{
		if($sql[$i] == ";" && !$in_string)
			{
			$ret[] = substr($sql, 0, $i);
			$sql = substr($sql, $i + 1);
			$i = 0;
			}

		if($in_string && ($sql[$i] == $in_string) && $buffer[1] != "\\")
			{
			$in_string = false;
			}

		elseif(!$in_string && ($sql[$i] == '"' || $sql[$i] == "'") && (!isset($buffer[0]) || $buffer[0] != "\\"))
			{
			$in_string = $sql[$i];
			}

		if(isset($buffer[1]))
			{
			$buffer[0] = $buffer[1];
			}

		$buffer[1] = $sql[$i];
		}

	if(!empty($sql))
		{
		$ret[] = $sql;
		}

	return($ret);
	}
?>