<?php
require_once('../redirecter.php');

function tgl_indo($tgl)
{

   $date  = substr($tgl,8,2);
   $month = get_bulan(substr($tgl,5,2));
   $year  = substr($tgl,0,4);
   return $date.' '.$month.' '.$year;

}

function get_bulan($bln) 
{
switch ($bln){
        case 1;
		  return "Jan";
		  break;
        case 2;
		  return "Feb";
		  break;
		case 3;
		  return "Mar";
		  break;
		case 4;
		  return "Apr";
		  break;
		case 5;
		  return "Mei";
		  break;
		case 6;
		  return "Jun";
		  break;
		case 7;
		  return "Jul";
		  break;
		case 8;
		  return "Agu";
		  break;
		case 9;
		  return "Sept";
		  break;
		case 10;
		  return "Okt";
		  break;
		case 11;
		  return "Nov";
		  break;
		case 12;
		  return "Des";
		  break;

}

}

?>
