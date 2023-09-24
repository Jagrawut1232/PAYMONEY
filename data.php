<?php
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","root","","paymoney");

$today=date("Y-m-d"); 
$t=explode('-',$today);
$Y=$t[0];
$M=$t[1];

$d1=mktime(0,0,0,$M,1,$Y);
$datestart=date("Y-m-d",$d1);
$a=$Y%4;
switch($M){  //กำหนดวันสิ้นเดือนแต่ละเดือน
case "1":$d2=mktime(0,0,0,$M,31,$Y); break;
case "3":$d2=mktime(0,0,0,$M,31,$Y); break;
case "4":$d2=mktime(0,0,0,$M,30,$Y); break;
case "5":$d2=mktime(0,0,0,$M,31,$Y); break;
case "6":$d2=mktime(0,0,0,$M,30,$Y); break;
case "7":$d2=mktime(0,0,0,$M,31,$Y); break;
case "8":$d2=mktime(0,0,0,$M,31,$Y); break;
case "9":$d2=mktime(0,0,0,$M,30,$Y); break;
case "10":$d2=mktime(0,0,0,$M,31,$Y); break;
case "11":$d2=mktime(0,0,0,$M,30,$Y); break;
case "12":$d2=mktime(0,0,0,$M,31,$Y); break;
case "2":  //กำหนดวันสิ้นเดือนกุมภาพันธ์
if($a=0){
$d2=mktime(0,0,0,$M,29,$Y);
}else{
$d2=mktime(0,0,0,$M,28,$Y);
}break;
}
$dateend=date("Y-m-d",$d2); 

$sqlQuery = "SELECT branchPM,sum(pPM) as 'PM' FROM Tpaymoney WHERE datePM between '$datestart' and '$dateend'GROUP BY branchPM  ORDER BY branchPM";

$result = mysqli_query($conn,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
?>