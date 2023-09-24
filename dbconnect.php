<?php
// เชื่อมต่อฐานข้อมูลไฟล์ brightsmile
$servername="localhost";
$username="root";
$password="";
$dbname="paymoney";
$connect=mysqli_connect("$servername","$username","$password","$dbname");


date_default_timezone_set('Asia/Bangkok');

if($connect){ }
else{echo"เกิดข้อผิดพลาด:" .mysqli_connect_error();}
?>
